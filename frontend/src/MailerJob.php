<?php

namespace frontend\src;

use Yii;
use yii\base\BaseObject;

class MailerJob extends BaseObject implements \yii\queue\JobInterface
{
    public $mailfrom;
    public $mailto;
    public $title;
    public $body;
    
    public function __construct($mailfrom, $mailto, $title, $body, $config = [])
    {
        $this->mailfrom = $mailfrom;
        $this->mailto = $mailto;
        $this->title = $title;
        $this->body = $body;

        parent::__construct($config);
    }

    public function execute($queue)
    {
        Yii::$app->mailer->compose()
            ->setFrom($this->mailfrom)
            ->setTo($this->mailto)
            ->setSubject($this->title)
            ->setTextBody($this->body)
            ->send();
    }
}
