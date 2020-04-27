<?php declare(strict_types=1);

class SMSApi
{
    // Paramètres d'envoi
    private $token;
    private $from;
    // Retour
    private $retour;
    // Variables systèmes
    private $url_api_1 = "https://api.smsapi.com/sms.do";

    public function __construct(string $token, $from = 'Test')
    {
        $this->token = $token;
        $this->from = $from;
    }

    public function set_From($from) {
        $this->from = $from;
    }

    public function envoyer_un_sms(string $tel, string $msg): bool
    {
        $tel = str_replace(' ', '', $tel);
        if (substr($tel, 0, 1) == 0) {
            $tel = '33'.substr($tel,1);
        }

        $parametres = '?format=json';
        $parametres .= "&to=$tel"; // num téléphone
        $parametres .= '&from=' . urlencode($this->from);
        $parametres .= '&message=' . urlencode($msg); // msg parent

        $url = "{$this->url_api_1}$parametres";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $this->token"
        ));
        $this->retour = curl_exec($ch);
        curl_close($ch);
        return true;
    }

    public function get_Retour_str(): string
    {
        return $this->retour;
    }
}
