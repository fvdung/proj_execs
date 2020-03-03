<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;

class AuthController extends AppController
{
    private $endPoint;

    public function __construct($request = null)
    {
        parent::__construct($request);

        $this->endPoint = Configure::read('bankid.end_point');
    }

    /**
     * Get bankID's autoStartToken && orderRef
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        if ($this->request->is('post')) {
            $response = $this->getAccessToken($this->request->getData('personal_number'));

            if (!$response) {
                $this->Flash->error('Bad request!');
            }
            $response = json_decode($response, true);
            $this->log(json_encode($response));

            if (!empty($response['errorCode'])) {
                $this->Flash->error($response['details']);
                return $this->redirect('/auth');
            }

            $this->set([
                'orderRef' => $response['orderRef']
            ]);

            return $this->setAction('verify');
        }
    }

    public function verify()
    {
    }

    public function getUser()
    {
        if ($this->request->is('post')) {
            $endPoint = $this->endPoint . '/collect';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $endPoint);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_VERBOSE, true);
            curl_setopt($curl, CURLOPT_CAINFO, Configure::read('bankid.path_cacert'));
            curl_setopt($curl, CURLOPT_CAPATH, Configure::read('bankid.path_cacert'));
            curl_setopt($curl, CURLOPT_SSLCERT, Configure::read('bankid.path_cert'));
            curl_setopt($curl, CURLOPT_SSLCERTPASSWD, 'qwerty123');

            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
                'orderRef' => $this->request->getData('order_ref')
            ]));

            $response = curl_exec($curl);
            $this->log(json_encode($response));
            if ($response) {
                $this->Flash->success('Successfully');
                $this->set([
                    'data' => json_decode($response, true)
                ]);
            } else {
                $this->Flash->error('Invalid token, please try again!');
            }
        }
        return $this->setAction('result');
    }

    public function result()
    {
    }

    /**
     * Get bankID's autoStartToken && orderRef
     *
     * @param string $personalNumber
     * @return string
     */
    private function getAccessToken(string $personalNumber): string
    {
        $endPoint = $this->endPoint . '/auth';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endPoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_VERBOSE, true);

        curl_setopt($curl, CURLOPT_CAINFO, Configure::read('bankid.path_cacert'));
        curl_setopt($curl, CURLOPT_CAPATH, Configure::read('bankid.path_cacert'));
        curl_setopt($curl, CURLOPT_SSLCERT, Configure::read('bankid.path_cert'));
        curl_setopt($curl, CURLOPT_SSLCERTPASSWD, 'qwerty123');

        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
            'personalNumber' => $personalNumber,
            'endUserIp' => $_SERVER['SERVER_ADDR'] ?? '192.168.1.1',
        ]));

        return curl_exec($curl);
    }
}
