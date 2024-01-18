<?php

namespace Src\Controller;

use Src\TableGateways\ShoeGateway;

class ShoeController
{

    private $db;
    private $requestMethod;
    private $shoeId;

    private $shoeGateway;

    public function __construct($db, $requestMethod, $shoeId)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->shoeId = $shoeId;

        $this->shoeGateway = new ShoeGateway($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->shoeId) {
                    $response = $this->getShoe($this->shoeId);
                } else {
                    $response = $this->getAllShoes();
                };
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
        return $response['body'];
    }

    private function getAllShoes()
    {
        $result = $this->shoeGateway->findAll();
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function getShoe($id)
    {
        $result = $this->shoeGateway->find($id);
        if (!$result) {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
