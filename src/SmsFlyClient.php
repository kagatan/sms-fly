<?php

namespace Kagatan\SmsFly;


class SmsFlyClient
{
    /**
     * Server
     *
     * @var string
     */
    protected $server = 'http://sms-fly.com/api/api.php';


    /**
     * API Login
     *
     * @var null
     */
    protected $login = null;


    /**
     * API Pass
     *
     * @var null
     */
    protected $password = null;

    /**
     * From
     *
     * @var null
     */
    protected $from = null;


    /**
     * Last response
     *
     * @var array
     */
    private $_last_response = array();

    /**
     * Errors
     *
     * @var array
     */
    protected $_errors = array();


    public function __construct($params = [])
    {
        if (!empty($params['login'])) {
            $this->login = $params['login'];
        }

        if (!empty($params['password'])) {
            $this->password = $params['password'];
        }

        if (!empty($params['from'])) {
            $this->from = $params['from'];
        }
    }


    /**
     * Send SMS
     *
     * @param $params
     * @return string
     */
    public function send($params = array())
    {
        if (empty($params['from'])) {
            $params['from'] = $this->from;
        }

        $result = $this->execute($params);

        if (strpos($result, 'code="ACCEPT"') !== false) {
            $begin = intval(strpos($result, 'campaignID="')) + intval(strlen('campaignID="'));
            return substr($result, $begin, intval(strpos($result, '" date="')) - $begin);
        } else {
            return '';
        }
    }


    /**
     * Send request
     *
     * @param array $params
     * @return mixed|null
     */
    protected function execute($params = array(), $dataXML)
    {
        //Если не переопределения праметром используем default
        if (empty($params['login']) AND empty($params['password'])) {
            $params['login'] = $this->login;
            $params['password'] = $this->password;
        }

        $dataXML = $this->buildXML($dataXML);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD, $params['login'] . ':' . $params['password']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $this->server);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: text/xml",
            "Accept: text/xml"
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataXML);
        $response = curl_exec($ch);
        curl_close($ch);

        $this->_last_response = $response;

        if ($response) {
            if (strpos($response, 'code="XMLERROR"') !== false) {
                $this->_errors[] = 'XMLERROR';
            } elseif (strpos($response, 'code="ERRPHONES"') !== false) {
                $this->_errors[] = 'ERRPHONES';
            } elseif (strpos($response, 'code="ERRSTARTTIME"') !== false) {
                $this->_errors[] = 'ERRSTARTTIME';
            } elseif (strpos($response, 'code="ERRENDTIME"') !== false) {
                $this->_errors[] = 'ERRENDTIME';
            } elseif (strpos($response, 'code="ERRLIFETIME"') !== false) {
                $this->_errors[] = 'ERRLIFETIME';
            } elseif (strpos($response, 'code="ERRSPEED"') !== false) {
                $this->_errors[] = 'ERRSPEED';
            } elseif (strpos($response, 'code="ERRALFANAME"') !== false) {
                $this->_errors[] = 'ERRALFANAME';
            } elseif (strpos($response, 'code="ERRTEXT"') !== false) {
                $this->_errors[] = 'ERRTEXT';
            } elseif (strpos($response, 'code="INSUFFICIENTFUNDS"') !== false) {
                $this->_errors[] = 'INSUFFICIENTFUNDS';
            } elseif (strpos($response, 'code="ERRALFANAME"') !== false) {
                $this->_errors[] = 'ERRALFANAME';
            } else {
                $this->_errors[] = $response;
            }
        } else {
            $this->_errors[] = 'CONNECTION ERROR';
        }

        return $this->_last_response;
    }


    private function buildXML($params)
    {

        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $xml .= "<request>";
        $xml .= "<operation>SENDSMS</operation>";
        $xml .= '		<message start_time="' . $params['start_time'] . '" end_time="' . $params['end_time'] . '" lifetime="' . $params['lifetime'] . '" rate="' . $params['rate'] . '" desc="' . $params['desc'] . '" source="' . $params['from'] . '">' . "\n";
        $xml .= "		<body>" . $params['message'] . "</body>";
        $xml .= "		<recipient>" . $params['to'] . "</recipient>";
        $xml .= "</message>";
        $xml .= "</request>";

        return $xml;
    }

    /**
     * Get last response
     *
     * @return array
     */
    public function getResponse()
    {
        return $this->_last_response;
    }

    /**
     * Return array of errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * Returns number of errors
     * @return int
     */
    public function hasErrors()
    {
        return count($this->_errors);
    }

}