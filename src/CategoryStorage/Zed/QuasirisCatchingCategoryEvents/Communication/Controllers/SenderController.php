<?php

namespace Quasiris\Zed\QuasirisCatchingCategoryEvents\Communication\Controllers;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Quasiris\Zed\QuasirisCatchingCategoryEvents\Communication\Controllers\MixedController;


class SenderController extends AbstractController { 

    public function getDataFromApi(array $params, $urls) {
        return $this->sendDataToApi($params, $urls);
    }
    
    public function sendDataToApi(array $params, $urls) { 
        $mixed = new MixedController();

        $id = (isset($params['productId'])) ? $params['productId'] : null;
        $type = (isset($params['type'])) ? $params['type'] : null;
        $data_to_send = [];
        $response_from_main_api = null;
        $url_main_api = null;
        $product = null;
        
        //sending to main url
        if(isset($urls['API_URL_MAIN'])) {
            $type_query = "POST";
            if(isset($params['eventName']) && $params['eventName'] == 'Category.after.delete') {
                $type_query = "DELETE";
            }

            $product['abstract'] = $params['abstract'];
            $product['concrete'] = $params['concrete'];
            $product['categories'] = $params['categories'];

            // send to quasiris api 
            $url = $urls['API_URL_MAIN'].'/'.$type.'/'.$id;
            try {
                $client = new \GuzzleHttp\Client();
                $response = $client->request($type_query, $url, [
                    // 'body' => json_encode($product),
                    'form_params' => $product,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'accept'     => '*/*'
                    ]
                ]);
                $stream = $response->getBody()->getContents();
                $response_from_main_api = json_decode($stream);
                $url_main_api = $url;
            } catch(ServerException $e) {
                $this->sendToMyApi($urls['API_URL_TESTING'], [
                    'status' => 'Error',
                    'name' => 'After send to quasiris',
                    'error_data' => json_encode($e)
                ]);
            }
        }
        
        //sending to test url with response from main url or not
        if(isset($urls['API_URL_TESTING'])) {
            //send to my api
            $data_to_send['status'] = 'SUCCESS';
            $data_to_send['params'] = $params;
            $data_to_send['eventName'] = $params['eventName'];
            $data_to_send['request_form_params_main_api'] = $product;
            $data_to_send['response_from_main_api'] = $response_from_main_api;
            $data_to_send['url_main_api'] = $url_main_api;
            $data_to_send['url_testing_api'] = $urls['API_URL_TESTING'];

            if($type === 'categories') { $data_to_send['category_id'] = $id; } else { $data_to_send['product_id'] = $id; }
            try {
                $this->sendToMyApi($urls['API_URL_TESTING'] , $data_to_send);
            } catch(ServerException $e) {
                $this->sendToMyApi($urls['API_URL_TESTING'], [
                    'status' => 'Error',
                    'error_data' => json_encode($e)
                ]);
            }
        }
    }

    private function sendToMyApi($url, $arr) {
        $client = new \GuzzleHttp\Client();
        $r = $client->request( 'POST',$url, [
            'body' => json_encode($arr),
        ]);
        return $r->getBody();
    }
}