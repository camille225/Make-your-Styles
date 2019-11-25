<?php

function get($id, $options)
{
    return array();
}

function post($data, $options)
{
    if ( ACTIVER_FORMULAIRE_INSCRIPTION )
    {
        $mf_login = ( isset($data['mf_login']) ? $data['mf_login'] : '' );
        $mf_pwd = ( isset($data['mf_pwd']) ? $data['mf_pwd'] : '' );
        $mf_pwd_2 = ( isset($data['mf_pwd_2']) ? $data['mf_pwd_2'] : '' );
        $mf_email = ( isset($data['mf_email']) ? $data['mf_email'] : '' );
        $mf_email_2 = ( isset($data['mf_email_2']) ? $data['mf_email_2'] : '' );

        $mf_connexion = new Mf_Connexion(true);
        $retour_json = $mf_connexion->inscription($mf_login, $mf_pwd, $mf_pwd_2, $mf_email, $mf_email_2);
    }
    else
    {
        $retour_json = array();
    }

    return $retour_json;
}

function put($id, $data, $options)
{
    return array();
}

function delete($id, $options)
{
    return array();
}
