<?php

namespace console\controllers;


use common\components\LightShopImportXML; 

use Yii;
use yii\console\Controller;
use yii\db\Expression;

use common\models\Word;
use common\models\Link;

use TelegramBot\Api\BotApi;

class TelegramController extends Controller
{
    //** Отправляем в английски чат 5 слов */
    public function actionWord()
    {
        $time_from = strtotime('-10 day', time());
        $delta_from = date('Y-m-d H:i:s', $time_from);

        $query = Word::find()->orderBy(['rand()' => SORT_DESC, new \yii\db\Expression('last_update IS NULL ASC')])
                                                ->where(['is', 'last_update', new \yii\db\Expression('null')])
                                                ->orWhere(['<=', 'last_update', $delta_from])
                                                ->andWhere(['=', 'send_telegram', 0])
                                                ->limit(5)
                                                ->asArray()->all();




        $messageText = '';
        foreach ($query as $model) 
        {
            $word = str_replace("'", "\'", $model['word']);   
            $word_item = "{$word} - {$model['translation']}" . ";\n";
            $id_array[] = $model['id'];
            $messageText = $messageText . $word_item ;

            $model = Word::findOne((int)$model['id']);//make a typecasting
            if ($model != null)
            {
                $model->last_update = new Expression('NOW()');
                $model->send_telegram = true;
                $model->save(false); 
            }
        }
                                               
        $chatId = '783781261';

        $bot = new BotApi('970747361:AAHo0ZxfAlAPwoBgE71lEX6YPq-j-6CyAfk');
            // Set webhook

        //$bot->setProxy('root:6zd4{k879B8$@195.161.41.150:3128');
        $bot->sendMessage($chatId, $messageText, 'HTML');       
    }

    /**
     * Send three words all category without stick telegramm
     */
    public function actionThreeWord()
    {
        $time_from = strtotime('-10 day', time());
        $delta_from = date('Y-m-d H:i:s', $time_from);

        $query = Word::find()->orderBy(['rand()' => SORT_DESC, new \yii\db\Expression('last_update IS NULL ASC')])
                                                ->where(['is', 'last_update', new \yii\db\Expression('null')])
                                                ->orWhere(['<=', 'last_update', $delta_from])
                                                ->limit(2)
                                                ->asArray()->all();


        $messageText = '';
        foreach ($query as $model) 
        {
            $word = str_replace("'", "\'", $model['word']);   
            $word_item = "{$word} - {$model['translation']}" . ";\n";
            $id_array[] = $model['id'];
            $messageText = $messageText . $word_item ;

            $model = Word::findOne((int)$model['id']);//make a typecasting
            if ($model != null)
            {
                $model->last_update = new Expression('NOW()');
                //$model->send_telegram = true;
                $model->save(false); 
            }
        }
                                               
        $chatId = '783781261';

        $bot = new BotApi('970747361:AAHo0ZxfAlAPwoBgE71lEX6YPq-j-6CyAfk');
        

        //$bot->setProxy('root:6zd4{k879B8$@195.161.41.150:3128');
        $bot->sendMessage($chatId, $messageText, 'HTML'); 
    }

    /**
     * Send three words all category without stick telegramm
     */
    public function actionThreeWordTor()
    {
        $time_from = strtotime('-10 day', time());
        $delta_from = date('Y-m-d H:i:s', $time_from);

        $query = Word::find()->orderBy(['rand()' => SORT_DESC, new \yii\db\Expression('last_update IS NULL ASC')])
                                                ->where(['is', 'last_update', new \yii\db\Expression('null')])
                                                ->orWhere(['<=', 'last_update', $delta_from])
                                                ->limit(2)
                                                ->asArray()->all();

        $messageText = '';
        foreach ($query as $model) 
        {
            $word = str_replace("'", "\'", $model['word']);   
            $word_item = "{$word} - {$model['translation']}" . ";\n";
            $id_array[] = $model['id'];
            $messageText = $messageText . $word_item ;

            $model = Word::findOne((int)$model['id']);//make a typecasting
            if ($model != null)
            {
                $model->last_update = new Expression('NOW()');
                //$model->send_telegram = true;
                $model->save(false); 
            }
        }

        $torSocks5Proxy = "socks5://127.0.0.1:9050";
        $chatId = '783781261';
        $bot = new BotApi('970747361:AAHo0ZxfAlAPwoBgE71lEX6YPq-j-6CyAfk');
        $bot->setProxy($torSocks5Proxy);

        //$bot->setProxy('root:6zd4{k879B8$@195.161.41.150:3128');
        $bot->sendMessage($chatId, $messageText, 'HTML'); 
    }



    public function actionLinkWord()
    {
        $time_from = strtotime('-2 day', time());
        $delta_from = date('Y-m-d H:i:s', $time_from);

        $modelLink = Link::find()->orderBy(['rand()'=> SORT_DESC])->one();;
        $json_words = $modelLink->id_word;
        $data_array = json_decode($json_words, true);

        $query = Word::find()->where(['in', 'id', $data_array])
                             ->andWhere(['<=', 'last_update', $delta_from])
                             ->limit(5)
                             ->asArray()->all();

        $messageText = '';
        foreach ($query as $model) 
        {
            $word = str_replace("'", "\'", $model['word']);   
            $word_item = "{$word} - {$model['translation']}" . ";\n";
            $id_array[] = $model['id'];
            $messageText = $messageText . $word_item ;

            $model = Word::findOne((int)$model['id']);//make a typecasting
            if ($model != null)
            {
                $model->last_update = new Expression('NOW()');
                $model->send_telegram = true;
                $model->save(false); 
            }
        }

        $chatId = '783781261';

        $bot = new BotApi('970747361:AAHo0ZxfAlAPwoBgE71lEX6YPq-j-6CyAfk');
            // Set webhook

        //$bot->setProxy('root:6zd4{k879B8$@195.161.41.150:3128');
        $bot->sendMessage($chatId, $messageText, 'HTML'); 


    }

    //Old method
    public function actionPush()
    {
        $time_from = strtotime('-10 day', time());
        $delta_from = date('Y-m-d H:i:s', $time_from);

        $query = Word::find()->orderBy(['rand()' => SORT_DESC, new \yii\db\Expression('last_update IS NULL ASC')])
                                                ->where(['is', 'last_update', new \yii\db\Expression('null')])
                                                ->orWhere(['<=', 'last_update', $delta_from])
                                                ->limit(1)
                                                ->asArray()->all();
        $messageText = '';
        foreach ($query as $model) 
        {
            $word = str_replace("'", "\'", $model['word']);   
            $word_item = "{$word} - {$model['translation']}";
            $id_array[] = $model['id'];
            $url = "https://pushall.ru/api.php?type=broadcast&id=2282&key=9165ef43d6e7cf04660ef95348579c17&title=English&text={$word_item}";
            file_get_contents($url);

            $model = Word::findOne((int)$model['id']);//make a typecasting
            if ($model != null)
            {
                $model->last_update = new Expression('NOW()');
                $model->send_telegram = true;
                $model->save(false); 
            }
        }                                        

    }
}