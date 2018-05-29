<?php
namespace App\Subscribes;

use Exception;
use App\Services\Service;

class UserEventSubscribe extends Service
{

    /**
     * 完善信息
     * @return [type] [description]
     */
    public function Information($event)
    {
        $user = $event->user;
        /*附件id*/
        $attachment_id = $event->attachment_id;

        /*修改数据*/
        $data = $event->data;
        /*获取列表*/
        $attachIds =  $this->attachmentRepo->listByIds($attachment_id,$user->id)->keyBy('id')->keys()->toArray();
        /*处理附件*/
        $data->attachments()->attach($attachIds);


    }


    public function subscribe($events)
    {
        /*用户信息完善*/
        $events->listen(
            'App\Events\User',
            'App\Subscribes\UserEventSubscribe@Information'

        );

    }
}