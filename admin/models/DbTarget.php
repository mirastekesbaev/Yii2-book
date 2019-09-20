<?php
/**
 * Created by PhpStorm.
 */

namespace admin\models;

/**
 * Modification of database logging for category 'book' Logger::LEVEL_INFO
 * added columns: user_id, book_id
 *
 * Class DbTarget
 * @package admin\models
 */
class DbTarget extends  \yii\log\DbTarget
{

    /**
     * Stores log messages to DB.
     */
    public function export()
    {
        $tableName = $this->db->quoteTableName($this->logTable);
        $sql = "INSERT INTO $tableName ([[level]], [[category]], [[log_time]], [[prefix]], [[message]], [[user_id]], [[book_id]])
                VALUES (:level, :category, :log_time, :prefix, :message, :user_id, :book_id)";
        $command = $this->db->createCommand($sql);
        foreach ($this->messages as $message) {
            list($text, $level, $category, $timestamp) = $message;
            if (!is_string($text)) {
                $text = VarDumper::export($text);
            }
            if($category === 'book'){
                $m = explode('_', $text);
                $book_id = $m[0];
                $text = end($m);
            }
            $command->bindValues([
                ':level' => $level,
                ':category' => $category,
                ':log_time' => $timestamp,
                ':prefix' => $this->getMessagePrefix($message),
                ':message' => $text,
                ':user_id' => \Yii::$app->user->id ? \Yii::$app->user->id : null,
                ':book_id' => isset($book_id) ? $book_id : '',
            ])->execute();
        }
    }

}