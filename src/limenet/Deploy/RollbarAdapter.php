<?php

namespace limenet\Deploy;

use Curl\Curl;

class RollbarAdapter implements PostDeployAdapterInterface
{
    private $config;

    public function config(array $config) : void
    {
        $this->config = $config;
    }

    public function run(Deploy $deploy) : bool
    {
        $curl = new Curl();
        $curl->post('https://api.rollbar.com/api/1/deploy/', [
            'access_token'   => $this->config['token'],
            'environment'    => $deploy->getEnv(),
            'revision'       => $deploy->getVersion(),
            'local_username' => 'limenet/deploy',
        ]);

        return $curl->error;
    }
}
