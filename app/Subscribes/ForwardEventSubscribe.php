<?php
namespace App\Subscribes;

use Exception;
use App\Services\Service;

class ForwardEventSubscribe extends Service
{

    /**
     * 卡密提现关联
     * @return [type] [description]
     */
    public function relationCamForward($event)
    {
        $forwards = $event->forwards;

        $camIds = $event->camIds;

        foreach($camIds as $ids) {
            $arrs = [
                'forward_id' => $forwards->id,
                'cam_id' => $ids,
                'status' => '1',
            ];
            if( $present = $this->presentForwardRepo->create($arrs) ) {

            } else {
                throw new Exception('卡密关联失败',2);

            }
        }
    }

    /**
     * 直充提现关联
     * @return [type] [description]
     */
    public function relationSupplyForward($event)
    {
        $forwards = $event->forwards;

        $forwardIds = $event->forwardIds;

        foreach($forwards as $id){
            $arrs = [
                'forward_id' => $forwards->id,
                'supply_id' => $id,
                'status' => '1',
            ];
           if( $supplyForward = $this->presentForwardRepo->create($arrs) ) {

           }else{
               throw new Exception('直充关联失败',2);
           }
        }

    }



    /**
     * 提现状态 --提现中
     * @return [type] [description]
     */
    public function toUpdateForwardSource($event)
    {
        $camIds = $event->camIds;

        $supplyIds = $event->supplyIds;

        foreach ( $camIds as $key => $val ) {
          $upCamStatus =   $this->supplyCamRepo->update(['forward_status' => 3],$val);
        }

        foreach ($supplyIds as $k => $v ) {
           $upSingletatus =   $this->supplySingleRepo->update(['forward_status' => 3],$v);
        }

    }

    public function subscribe($events)
    {
        /*提现状态*/
        $events->listen(
            'App\Events\Accommed\Forward',
            'App\Subscribes\ForwardEventSubscribe@toUpdateForwardSource'
        );
        /*卡密提现关联*/
        $events->listen(
            'App\Events\Accommed\RelationPresentForward',
            'App\Subscribes\ForwardEventSubscribe@relationCamForward'
        );

        /*直充提现关联*/
        $events->listen(
            'App\Events\Accommed\RelationForward',
            'App\Subscribes\ForwardEventSubscribe@relationSupplyForward'
        );

    }
}