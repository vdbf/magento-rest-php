<?php namespace Vdbf\Magento\Auth;

use OAuth;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class OAuthTokenRequester
 * @package Vdbf\Magento\Auth
 */
class OAuthTokenRequester
{

    const STATE_REQUEST_TOKEN = 0;
    const STATE_USER_AUTH = 1;
    const STATE_ACCESS_TOKEN = 2;
    const STATE_READY = 3;

    /**
     * @var array
     */
    private $credentials;

    /**
     * @param $credentials
     * @param OAuth $client
     */
    public function __construct($credentials, $urls)
    {
        $this->credentials = $credentials;
        $this->urls = $urls;
    }

    /**
     * @param $request
     */
    public function route(Request $request)
    {
        $state = $this->getStateFromRequest($request);
        $client = $this->resolveOAuthClient($state, $this->credentials);

        switch ($state) {
            case static::STATE_REQUEST_TOKEN:

                $this->accuireRequestToken($client, $request);

                break;

            case static::STATE_USER_AUTH:

                $this->accuireUserAuthentication($request);

                break;

            case static::STATE_ACCESS_TOKEN;
                $this->accuireAccessToken($client, $request);

                break;

            case static::STATE_READY:
                $this->printAccessTokenAndSecret($this->resolveSession($request));
                break;

            default:
                throw new Exception('Router encountered an invalid state');
        }
    }

    protected function accuireRequestToken($client, $request)
    {
        $requestToken = $client->getRequestToken($this->buildInitiateUrl());

        $session = $this->resolveSession($request);
        $session->set('token', $requestToken['oauth_token']);
        $session->set('secret', $requestToken['oauth_token_secret']);
        $session->set('state', static::STATE_USER_AUTH);

        //next step
        $this->route($request);
    }

    protected function accuireUserAuthentication($request)
    {
        $session = $this->resolveSession($request);
        $session->set('state', static::STATE_ACCESS_TOKEN);

        //next step
        header('Location: ' . $this->buildAuthorizationUrl($session->get('token')));
        exit;
    }

    protected function accuireAccessToken($client, $request)
    {
        $session = $this->resolveSession($request);

        $client->setToken($request->get('oauth_token'), $session->get('secret'));

        $accessToken = $client->getAccessToken($this->buildAccessTokenRequestUrl());

        $session->set('token', $accessToken['oauth_token']);
        $session->set('secret', $accessToken['oauth_token_secret']);
        $session->set('state', static::STATE_READY);

        //next step
        $this->route($request);
    }

    protected function buildInitiateUrl()
    {
        return $this->urls['initiate'] . urlencode($this->urls['callback']);
    }

    protected function buildAuthorizationUrl($token)
    {
        return $this->urls['authorize'] . $token;
    }

    protected function buildAccessTokenRequestUrl()
    {
        return $this->urls['token'];
    }

    protected function getStateFromRequest(Request $request)
    {
        $session = $this->resolveSession($request);

        if (!$request->get('oauth_token', false) && !$session->get('state', false)) {
            //next step is aquiring a request token
            return static::STATE_REQUEST_TOKEN;
        }

        if ($session->has('state')) {
            return $session->get('state');
        }
    }

    /**
     * @param $state
     * @param $credentials
     * @return null|OAuth
     */
    protected function resolveOAuthClient($state, $credentials)
    {
        if ($state == static::STATE_READY) {
            return null;
        }

        return new OAuth(
            $credentials['key'],
            $credentials['secret'],
            OAUTH_SIG_METHOD_HMACSHA1,
            OAUTH_AUTH_TYPE_URI
        );
    }

    /**
     * @param SessionInterface $session
     */
    protected function printAccessTokenAndSecret(SessionInterface $session)
    {
        $credentials = array(
            'token' => $session->get('token'),
            'secret' => $session->get('secret')
        );
        print_r($credentials);
    }

    protected function resolveSession(Request $request)
    {
        return $request->hasSession() ? $request->getSession() : new Session();
    }
} 