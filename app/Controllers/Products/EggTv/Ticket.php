<?php

namespace App\Controllers\Products\EggTv;

use App\Controllers\BaseController;
use App\Models\InvokeProcedureModel;
use Exception;

/**
 * @OA\Tag(
 *     name="Ticket",
 *     description="EGG TV 이용권 관련 API. 이용권 조회, 발행, 코드 발급 등을 포함합니다."
 * )
 */
class Ticket extends BaseController
{
    protected InvokeProcedureModel $spModel;
    protected string $callDate;

    public function __construct()
    {
        $this->spModel = new InvokeProcedureModel();
        $this->callDate = date('Y-m-d H:i:s');
    }

    /**
     * @OA\Get (
     *     path="/api/v1/retail_eggtv",
     *     summary="이용권 목록",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="operatorId",
     *         in="query",
     *         required=true,
     *         description="운영자 ID",
     *         @OA\Schema(type="string", example="1")
     *     ),
     *     @OA\Parameter(
     *         name="teamId",
     *         in="query",
     *         required=true,
     *         description="팀 ID",
     *         @OA\Schema(type="string", example="2")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="정상 처리",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 nullable=true,
     *                 @OA\Property(property="eggtv_ticket_id", type="string", example="109", description="이용권 ID"),
     *                 @OA\Property(property="eggtv_ticket_name", type="string", example="라이트 이용권", description="이용권 이름"),
     *                 @OA\Property(property="eggtv_ticket_type", type="string", example="0", description="이용권 유형(0=SUBSCRIPTION=기간 이용권,1=TIER_UPGRADE=구독 등급 업그레이드)"),
     *                 @OA\Property(property="subscription_tier", type="string", example="1", description="구독 티어(1=LITE=라이트,2=STANDARD=스탠다드,3=PLUS=플러스,4=PREMIUM=프리미엄)"),
     *                 @OA\Property(property="has_fixed_end_date", type="string", example="0", description="이용권의 종료 일자가 명시적으로 정해져 있는지 여부"),
     *                 @OA\Property(property="subscription_days", type="string", example="20", description="구독 기간 OR 업그레이드 적용 기간(단위: 일)")
     *             ),
     *             @OA\Property(property="code", type="string", example="200"),
     *             @OA\Property(property="message", type="string", example="")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="조회 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="500"),
     *             @OA\Property(property="message", type="string", example="데이터를 조회할 수 없습니다.")
     *         )
     *     )
     * )
     */
    public function readAllTickets()
    {
        try {
            $operatorId = $this->request->getVar('operatorId') ?? 1;
            $teamId = $this->request->getVar('teamId') ?? 2;
            if (!isset($operatorId) || !isset($teamId)) {
                return setResponseFormat($this->response, false, 'MISSING_REQUIRED_DATA', null);
            }

            $result = $this->spModel->executeSP('sp-op-eggtv_tickets-ra-v1', 4, [$operatorId, $teamId, SERVER_ADDR, $this->callDate]);
            return setResponseFormat($this->response, 200, null, $result);
        } catch (Exception $e) {
            return setResponseFormat($this->response, 500, $e->getMessage(), null);
        }
    }
}