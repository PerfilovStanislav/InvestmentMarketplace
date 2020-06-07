<?php

namespace Services;

use Facebook\Facebook;
use Traits\Instance;
use Mappers\FacebookMapper;

class FacebookService {
    use Instance;

    private Facebook $fb;

    protected function __construct()
    {
        $this->fb = new Facebook([
            'app_id'     => \Config::FB_APP_ID,
            'app_secret' => \Config::FB_APP_SECRET,
        ]);
    }

    public function sendPhoto(int $langId, string $pathToFile, string $description) {
        $pageId = FacebookMapper::getPageId($langId);
        $this->fb->setDefaultAccessToken(FacebookMapper::getPageToken($pageId));
        return $this->fb->post(sprintf('/%d/photos', $pageId), [
            'message' => $description,
            'source' => $this->fb->fileToUpload($pathToFile),
        ]);
    }

    public function generateAuthPageToken(int $pageId): string
    {
        $longLivedToken = $this->fb->getOAuth2Client()->getLongLivedAccessToken(\Config::FB_USER_TOKEN);
        $this->fb->setDefaultAccessToken($longLivedToken);
        return $this->fb->sendRequest('GET', $pageId, ['fields' => 'access_token'])->getDecodedBody()['access_token'];
    }
}