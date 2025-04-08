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
     *             @OA\Property(property="code", type="string", nullable=true, example=null),
     *             @OA\Property(property="message", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="인증 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="NOT_FOUND_MEMBER_INFO"),
     *             @OA\Property(property="message", type="string", example="회원정보를 찾을 수 없습니다.")
     *         )
     *     )
     * )
     */
    public function readAllTickets()
    {
        try {
            $operatorId = $this->request->getVar('operatorId');
            $teamId = $this->request->getVar('teamId');
            if (!isset($operatorId) || !isset($teamId)) {
                return setResponseFormat($this->response, 'NOT_FOUND_MEMBER_INFO', null);
            }

            $result = $this->spModel->executeSP('sp-op-eggtv_tickets-ra-v1', 4, [$operatorId, $teamId, SERVER_ADDR, $this->callDate]);
            return setResponseFormat($this->response, null, $result);
        } catch (Exception $e) {
            logException($e);
            return setResponseFormat($this->response, $e->getMessage(), null);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/retail_eggtv",
     *     summary="이용권 추가",
     *     tags={"Ticket"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="operatorId", type="string", example="1"),
     *                 @OA\Property(property="teamId", type="string", example="2"),
     *                 @OA\Property(property="name", type="string", example="에그티비 7일 이용권"),
     *                 @OA\Property(property="type", type="string", example="0"),
     *                 @OA\Property(property="tier", type="string", example="2"),
     *                 @OA\Property(property="hasEndDate", type="string", example="0"),
     *                 @OA\Property(property="days", type="string", example="10")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="정상 처리",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="eggtv_ticket_id", type="string", example="109", description="이용권 ID"),
     *             ),
     *             @OA\Property(property="code", type="string", nullable=true, example=null),
     *             @OA\Property(property="message", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="인증 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="NOT_FOUND_MEMBER_INFO"),
     *             @OA\Property(property="message", type="string", example="회원정보를 찾을 수 없습니다.")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="조회 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="DUPLICATED_EGGTV_TICKET_CONDITION || MISSING_REQUIRED_DATA"),
     *             @OA\Property(property="message", type="string", example="이미 등록된 에그TV 이용권 조건입니다. || 데이터를 입력해주세요.")
     *         )
     *     )
     * )
     */
    public function createTicket()
    {
        try {
            $data = $this->request->getJSON();

            $operatorId = $data->operatorId;
            $teamId = $data->teamId;
            $name = $data->name;
            $type = $data->type;
            $tier = $data->tier;
            $days = $data->days;
            $hasEndDate = $data->hasEndDate === 0 ? null : $data->hasEndDate;

            if (!isset($operatorId) || !isset($teamId)) {
                return setResponseFormat($this->response, 'NOT_FOUND_MEMBER_INFO', null);
            }
            if (!isset($name) || !isset($type) || !isset($tier)) {
                return setResponseFormat($this->response,'MISSING_REQUIRED_DATA', null);
            }

            $result = $this->spModel->executeSP('sp-op-eggtv_tickets-c-v2', 9, [$operatorId, $teamId, SERVER_ADDR, $name, $type, $tier, $hasEndDate, $days, $this->callDate]);
            return setResponseFormat($this->response, null, $result);
        } catch (Exception $e) {
            logException($e);
            return setResponseFormat($this->response, $e->getMessage(), null);
        }
    }

    /**
     * @OA\Get (
     *     path="/api/v1/retail_eggtv/{ticketId}",
     *     summary="이용권 조회",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="ticketId",
     *         in="path",
     *         required=true,
     *         description="이용권 ID",
     *         @OA\Schema(type="string", example="112")
     *     ),
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
     *                 @OA\Property(property="eggtv_ticket_id", type="string", example="97", description="이용권 ID"),
     *                 @OA\Property(property="eggtv_ticket_name", type="string", example="라이트 이용권", description="이용권 이름"),
     *                 @OA\Property(property="eggtv_ticket_type", type="string", example="0", description="이용권 유형(0=SUBSCRIPTION=기간 이용권,1=TIER_UPGRADE=구독 등급 업그레이드)"),
     *                 @OA\Property(property="subscription_tier", type="string", example="1", description="구독 티어(1=LITE=라이트,2=STANDARD=스탠다드,3=PLUS=플러스,4=PREMIUM=프리미엄)"),
     *                 @OA\Property(property="has_fixed_end_date", type="string", example="0", description="이용권의 종료 일자가 명시적으로 정해져 있는지 여부"),
     *                 @OA\Property(property="subscription_days", type="string", example="20", description="구독 기간 OR 업그레이드 적용 기간(단위: 일)"),
     *                 @OA\Property(property="operator_id", type="string", example="1", description="운영자 ID"),
     *                 @OA\Property(property="operator_name", type="string", example="김에그", description="운영자 이름"),
     *                 @OA\Property(property="register_date", type="string", example="2025-04-04", description="등록 일자")
     *             ),
     *             @OA\Property(property="code", type="string", nullable=true, example=null),
     *             @OA\Property(property="message", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="인증 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="NOT_FOUND_MEMBER_INFO"),
     *             @OA\Property(property="message", type="string", example="회원정보를 찾을 수 없습니다.")
     *         )
     *     )
     * )
     */
    public function readOneTicket($ticketId)
    {
        try {
            $operatorId = $this->request->getVar('operatorId');
            $teamId = $this->request->getVar('teamId');
            if (!isset($operatorId) || !isset($teamId)) {
                return setResponseFormat($this->response, 'NOT_FOUND_MEMBER_INFO', null);
            }

            $result = $this->spModel->executeSP('sp-op-eggtv_tickets-ro-v1', 5, [$operatorId, $teamId, SERVER_ADDR, $ticketId, $this->callDate]);
            return setResponseFormat($this->response, null, $result);
        } catch (Exception $e) {
            logException($e);
            return setResponseFormat($this->response, $e->getMessage(), null);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/retail_eggtv/{ticketId}",
     *     summary="이용권 삭제",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="ticketId",
     *         in="path",
     *         required=true,
     *         description="이용권 ID",
     *         @OA\Schema(type="string", example="112")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="operatorId", type="string", example="1"),
     *                 @OA\Property(property="teamId", type="string", example="2")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="정상 처리",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", nullable=true, example=null),
     *             @OA\Property(property="message", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="인증 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="NOT_FOUND_MEMBER_INFO"),
     *             @OA\Property(property="message", type="string", example="회원정보를 찾을 수 없습니다.")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="조회 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="ALREADY_ISSUED_EGGTV_TICKET || NOT_FOUND_EGGTV_TICKET || MISSING_REQUIRED_DATA"),
     *             @OA\Property(property="message", type="string", example="발행 이력이 있는 에그TV 이용권입니다. || 에그TV 이용권이 없습니다. || 데이터를 입력해주세요.")
     *         )
     *     )
     * )
     */
    public function deleteTicket($ticketId)
    {
        try {
            $operatorId = $this->request->getVar('operatorId');
            $teamId = $this->request->getVar('teamId');
            if (!isset($operatorId) || !isset($teamId)) {
                return setResponseFormat($this->response, 'NOT_FOUND_MEMBER_INFO', null);
            }

            $this->spModel->executeSP('sp-op-eggtv_tickets-d-v1', 5, [$operatorId, $teamId, SERVER_ADDR, $ticketId, $this->callDate]);
            return setResponseFormat($this->response, null, null);
        } catch (Exception $e) {
            logException($e);
            return setResponseFormat($this->response, $e->getMessage(), null);
        }
    }

    /**
     * @OA\Get (
     *     path="/api/v1/retail_eggtv/{ticketId}/issues",
     *     summary="이용권 코드 발행 이력",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="ticketId",
     *         in="path",
     *         required=true,
     *         description="이용권 ID",
     *         @OA\Schema(type="string", example="55")
     *     ),
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
     *                 @OA\Property(property="eggtv_ticket_issuing_id", type="string", example="8", description="이용권 발행 ID"),
     *                 @OA\Property(property="operator_id", type="string", example="1", description="운영자 ID"),
     *                 @OA\Property(property="operator_name", type="string", example="김에그", description="운영자 이름"),
     *                 @OA\Property(property="eggtv_ticket_alias", type="string", example="이용권 별칭", description="이용권 별칭"),
     *                 @OA\Property(property="issue_description", type="string", example="발행 사유", description="이용권 발행 설명"),
     *                 @OA\Property(property="max_registration_count", type="string", example="1", description="이용권 코드 1개 당 1명이 등록할 수 있는 최대 횟수"),
     *                 @OA\Property(property="eggtv_ticket_issuing_status", type="string", example="1", description="이용권 발행 상태(0=DISABLED=비활성,1=ENABLED=활성)"),
     *                 @OA\Property(property="issue_date", type="string", example="2024-12-04 13:40:18", description="발행 일자"),
     *                 @OA\Property(property="total_issue_count", type="string", example="1", description="총 발행 수량"),
     *                 @OA\Property(property="total_registration_count", type="string", example="0", description="총 등록 수량"),
     *                 @OA\Property(property="intended_use", type="string", example="1", description="사용 목적(0=CS=고객 보상,1=MARKETING=마케팅,2=QA_TEST=내부 테스트,255=EMPLOYEE_BENEFIT=임직원 복리후생)")
     *             ),
     *             @OA\Property(property="code", type="string", nullable=true, example=null),
     *             @OA\Property(property="message", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="인증 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="NOT_FOUND_MEMBER_INFO"),
     *             @OA\Property(property="message", type="string", example="회원정보를 찾을 수 없습니다.")
     *         )
     *     )
     * )
     */
    public function readAllTicketIssues($ticketId)
    {
        try {
            $operatorId = $this->request->getVar('operatorId');
            $teamId = $this->request->getVar('teamId');
            if (!isset($operatorId) || !isset($teamId)) {
                return setResponseFormat($this->response, 'NOT_FOUND_MEMBER_INFO', null);
            }

            $result = $this->spModel->executeSP('sp-op-eggtv_ticket_issuings-ra-v1', 5, [$operatorId, $teamId, SERVER_ADDR, $ticketId, $this->callDate]);
            return setResponseFormat($this->response,null, $result);
        } catch (Exception $e) {
            logException($e);
            return setResponseFormat($this->response, $e->getMessage(), null);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/retail_eggtv/{ticketId}/issues",
     *     summary="이용권 코드 발행",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="ticketId",
     *         in="path",
     *         required=true,
     *         description="이용권 ID",
     *         @OA\Schema(type="string", example="55")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="operatorId", type="string", example="1"),
     *                 @OA\Property(property="teamId", type="string", example="2"),
     *                 @OA\Property(property="alias", type="string", example="에그TV 이용권 별칭"),
     *                 @OA\Property(property="use", type="string", example="2"),
     *                 @OA\Property(property="description", type="string", example="이용권 발행 설명"),
     *                 @OA\Property(property="maxCount", type="string", example="5"),
     *                 @OA\Property(property="endDate", type="string", nullable=true, example=null),
     *                 @OA\Property(property="expiryDate", type="string", nullable=true, example="2025-06-30"),
     *                 @OA\Property(property="useByDays", type="string", example="7"),
     *                 @OA\Property(property="totalCount", type="string", nullable=true, example="10"),
     *                 @OA\Property(property="code", type="string", nullable=true, example=null),
     *                 @OA\Property(property="emNos", type="string", nullable=true, example=null)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="정상 처리",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="eggtv_ticket_code_id", type="string", example="109", description="이용권 코드 ID"),
     *             ),
     *             @OA\Property(property="code", type="string", nullable=true, example=null),
     *             @OA\Property(property="message", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="인증 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="NOT_FOUND_MEMBER_INFO"),
     *             @OA\Property(property="message", type="string", example="회원정보를 찾을 수 없습니다.")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="조회 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="NOT_FOUND_EGGTV_TICKET || INVALID_ARGUMENT || DUPLICATED_EGGTV_TICKET_CODE || MISSING_REQUIRED_DATA"),
     *             @OA\Property(property="message", type="string", example="에그TV 이용권이 없습니다. (pEggtvTicketId 값이 존재하지 않습니다.) || input argument가 올바르지 않습니다. (pSubscriptionEndDate) || 이미 발행한 에그TV 이용권 코드입니다. || 데이터를 입력해주세요.")
     *         )
     *     )
     * )
     */
    public function createTicketIssue($ticketId)
    {
        try {
            $data = $this->request->getJSON();

            $operatorId = $data->operatorId;
            $teamId = $data->teamId;
            if (!isset($operatorId) || !isset($teamId)) {
                return setResponseFormat($this->response, 'NOT_FOUND_MEMBER_INFO', null);
            }

            $alias = $data->alias;
            $use = $data->use;
            $description = $data->description;
            $maxCount = $data->maxCount ?? null;
            $endDate = $data->endDate ?? null;
            $expiryDate = $data->expiryDate;
            $useByDays = $data->useByDays;
            $totalCount = $data->totalCount ?? null;
            $code = $data->code ?? null;
            $emNos = $data->emNos ?? null;
            if (!isset($alias) || !isset($use) || !isset($description) || !isset($expiryDate) || !isset($useByDays)) {
                return setResponseFormat($this->response, 'MISSING_REQUIRED_DATA', null);
            }

            $result = $this->spModel->executeSP('sp-op-eggtv_ticket_issuings-c-v3', 15,
                [$operatorId, $teamId, SERVER_ADDR, $ticketId, $alias, $use, $description, $maxCount, $endDate, $expiryDate, $useByDays, $totalCount, $code, $emNos, $this->callDate]);
            return setResponseFormat($this->response, null, $result);
        } catch (Exception $e) {
            logException($e);
            return setResponseFormat($this->response, $e->getMessage(), null);
        }
    }

    /**
     * @OA\Get (
     *     path="/api/v1/retail_eggtv/{ticketId}/issues/{issueId}",
     *     summary="이용권 발행 속성 조회",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="ticketId",
     *         in="path",
     *         required=true,
     *         description="이용권 ID",
     *         @OA\Schema(type="string", example="55")
     *     ),
     *     @OA\Parameter(
     *         name="issueId",
     *         in="path",
     *         required=true,
     *         description="이용권 발행 ID",
     *         @OA\Schema(type="string", example="26")
     *     ),
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
     *                 @OA\Property(property="eggtv_ticket_issuing_id", type="string", example="26", description="이용권 발행 ID"),
     *                 @OA\Property(property="eggtv_ticket_id", type="string", example="55", description="이용권 ID"),
     *                 @OA\Property(property="eggtv_ticket_alias", type="string", example="라이트 이용권", description="이용권 별칭"),
     *                 @OA\Property(property="intended_use", type="string", example="2", description="사용 목적(0=CS=고객 보상,1=MARKETING=마케팅,2=QA_TEST=내부 테스트,255=EMPLOYEE_BENEFIT=임직원 복리후생)"),
     *                 @OA\Property(property="issue_description", type="string", example="이용권 발행 설명", description="이용권 발행 설명"),
     *                 @OA\Property(property="max_registration_count", type="string", example="5", description="이용권 코드 1개 당 1명이 등록할 수 있는 최대 횟수"),
     *                 @OA\Property(property="subscription_end_date", type="string", example=null, description="발행한 이용권 코드를 사용했을 때 구독이 종료되는 일자"),
     *                 @OA\Property(property="expiry_date", type="string", example="2025-06-30", description="등록 만료 일자"),
     *                 @OA\Property(property="use_by_days", type="string", example="7", description="등록 이후 사용 기한(단위: 일)"),
     *                 @OA\Property(property="eggtv_ticket_issuing_status", type="string", example="1", description="에그TV 이용권 발행 상태"),
     *                 @OA\Property(property="total_issue_count", type="string", example="10", description="총 발행 수량"),
     *                 @OA\Property(property="total_registration_count", type="string", example="0", description="총 등록 수량"),
     *                 @OA\Property(property="operator_id", type="string", example="1", description="운영자 ID"),
     *                 @OA\Property(property="operator_name", type="string", example="김에그", description="운영자 이름"),
     *                 @OA\Property(property="register_date", type="string", example="2025-04-07 02:05:31", description="발행 일자")
     *             ),
     *             @OA\Property(property="code", type="string", nullable=true, example=null),
     *             @OA\Property(property="message", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="인증 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="NOT_FOUND_MEMBER_INFO"),
     *             @OA\Property(property="message", type="string", example="회원정보를 찾을 수 없습니다.")
     *         )
     *     )
     * )
     */
    public function readOneTicketIssue($ticketId, $issueId)
    {
        try {
            $operatorId = $this->request->getVar('operatorId');
            $teamId = $this->request->getVar('teamId');
            if (!isset($operatorId) || !isset($teamId)) {
                return setResponseFormat($this->response, 'NOT_FOUND_MEMBER_INFO', null);
            }

            $result = $this->spModel->executeSP('sp-op-eggtv_ticket_issuings-ro-v1', 5, [$operatorId, $teamId, SERVER_ADDR, $issueId, $this->callDate]);
            return setResponseFormat($this->response, null, $result);
        } catch (Exception $e) {
            logException($e);
            return setResponseFormat($this->response, $e->getMessage(), null);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/retail_eggtv/{ticketId}/issues/{issueId}",
     *     summary="이용권 코드 발행 속성 수정",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="ticketId",
     *         in="path",
     *         required=true,
     *         description="이용권 ID",
     *         @OA\Schema(type="string", example="55")
     *     ),
     *     @OA\Parameter(
     *         name="issueId",
     *         in="path",
     *         required=true,
     *         description="이용권 발행 ID",
     *         @OA\Schema(type="string", example="26")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="operatorId", type="string", example="1"),
     *                 @OA\Property(property="teamId", type="string", example="2"),
     *                 @OA\Property(property="alias", type="string", nullable=true, example=null),
     *                 @OA\Property(property="description", type="string", nullable=true, example=null),
     *                 @OA\Property(property="maxCount", type="string",nullable=true, example=null),
     *                 @OA\Property(property="expiryDate", type="string", nullable=true, example=null),
     *                 @OA\Property(property="useByDays", type="string", nullable=true, example=null),
     *                 @OA\Property(property="status", type="string", nullable=true, example=null)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="정상 처리",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", nullable=true, example=null),
     *             @OA\Property(property="message", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="인증 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="NOT_FOUND_MEMBER_INFO"),
     *             @OA\Property(property="message", type="string", example="회원정보를 찾을 수 없습니다.")
     *         )
     *     )
     * )
     */
    public function updateTicketIssue($ticketId, $issueId)
    {
        try {
            $data = $this->request->getJSON();

            $operatorId = $data->operatorId;
            $teamId = $data->teamId;
            if (!isset($operatorId) || !isset($teamId)) {
                return setResponseFormat($this->response, 'NOT_FOUND_MEMBER_INFO', null);
            }

            $name = $data->name ?? null;
            $description = $data->description ?? null;
            $maxCount = $data->maxCount ?? null;
            $expiryDate = $data->expiryDate ?? null;
            $days = $data->days ?? null;
            $status = $data->status ?? null;

            $this->spModel->executeSP('sp-op-eggtv_ticket_issuings-u-v1', 11, [$operatorId, $teamId, SERVER_ADDR, $issueId, $name, $description, $maxCount, $expiryDate, $days, $status, $this->callDate]);
            return setResponseFormat($this->response, null, null);
        } catch (Exception $e) {
            logException($e);
            return setResponseFormat($this->response, $e->getMessage(), null);
        }
    }

    /**
     * @OA\Get (
     *     path="/api/v1/retail_eggtv/{ticketId}/issues/{issueId}/codes",
     *     summary="이용권 코드 목록",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="ticketId",
     *         in="path",
     *         required=true,
     *         description="이용권 ID",
     *         @OA\Schema(type="string", example="55")
     *     ),
     *     @OA\Parameter(
     *         name="issueId",
     *         in="path",
     *         required=true,
     *         description="이용권 발행 ID",
     *         @OA\Schema(type="string", example="26")
     *     ),
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
     *                 @OA\Property(property="eggtv_ticket_code", type="string", example="6A5JMHSC", description="에그TV 이용권 코드"),
     *                 @OA\Property(property="expiry_date", type="string", example="2025-06-30", description="등록 만료 일자"),
     *                 @OA\Property(property="eggtv_ticket_code_status", type="string", example="1", description="에그TV 이용권 코드 상태(0=DISABLED=비활성,1=ENABLED=활성)"),
     *                 @OA\Property(property="registration_count", type="string", example="0", description="등록 횟수"),
     *                 @OA\Property(property="use_count", type="string", example="0", description="사용 횟수")
     *             ),
     *             @OA\Property(property="code", type="string", nullable=true, example=null),
     *             @OA\Property(property="message", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="인증 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="NOT_FOUND_MEMBER_INFO"),
     *             @OA\Property(property="message", type="string", example="회원정보를 찾을 수 없습니다.")
     *         )
     *     )
     * )
     */
    public function readAllTicketCodes($ticketId, $issueId)
    {
        try {
            $operatorId = $this->request->getVar('operatorId');
            $teamId = $this->request->getVar('teamId');
            if (!isset($operatorId) || !isset($teamId)) {
                return setResponseFormat($this->response, 'NOT_FOUND_MEMBER_INFO', null);
            }

            $result = $this->spModel->executeSP('sp-op-eggtv_ticket_codes-ra-v1', 5, [$operatorId, $teamId, SERVER_ADDR, $issueId, $this->callDate]);
            return setResponseFormat($this->response, null, $result);
        } catch (Exception $e) {
            logException($e);
            return setResponseFormat($this->response, $e->getMessage(), null);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/retail_eggtv/{ticketId}/issues/{issueId}/codes",
     *     summary="이용권 코드 수정",
     *     tags={"Ticket"},
     *     @OA\Parameter(
     *         name="ticketId",
     *         in="path",
     *         required=true,
     *         description="이용권 ID",
     *         @OA\Schema(type="string", example="55")
     *     ),
     *     @OA\Parameter(
     *         name="issueId",
     *         in="path",
     *         required=true,
     *         description="이용권 발행 ID",
     *         @OA\Schema(type="string", example="26")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="operatorId", type="string", example="1"),
     *                 @OA\Property(property="teamId", type="string", example="2"),
     *                 @OA\Property(property="code", type="string", example="6A5JMHSC"),
     *                 @OA\Property(property="expiryDate", type="string", nullable=true, example=null),
     *                 @OA\Property(property="status", type="string", nullable=true, example=null)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="정상 처리",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="string", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", nullable=true, example=null),
     *             @OA\Property(property="message", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="인증 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="NOT_FOUND_MEMBER_INFO"),
     *             @OA\Property(property="message", type="string", example="회원정보를 찾을 수 없습니다.")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="조회 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="INVALID_CODE_VALUE"),
     *             @OA\Property(property="message", type="string", example="코드 값을 확인해주세요.")
     *         )
     *     )
     * )
     */
    public function updateTicketCode($ticketId, $codeId)
    {
        try {
            $data = $this->request->getJSON();

            $operatorId = $data->operatorId;
            $teamId = $data->teamId;
            if (!isset($operatorId) || !isset($teamId)) {
                return setResponseFormat($this->response, 'NOT_FOUND_MEMBER_INFO', null);
            }

            $code = $data->code;
            if (!isset($code)) {
                return setResponseFormat($this->response, 'INVALID_CODE_VALUE', null);
            }
            $codeExpiryDate = $data->expiryDate ?? null;
            $codeStatus = $data->status ?? null;

            $this->spModel->executeSP('sp-op-eggtv_ticket_codes-u-v1', 7, [$operatorId, $teamId, SERVER_ADDR, $code, $codeExpiryDate, $codeStatus, $this->callDate]);
            return setResponseFormat($this->response, null, null);
        } catch (Exception $e) {
            logException($e);
            return setResponseFormat($this->response, $e->getMessage(), null);
        }
    }

    /**
     * @OA\Get (
     *     path="/api/v1/retail_eggtv/search",
     *     summary="이용권 코드 검색",
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
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         required=true,
     *         description="이용권 코드",
     *         @OA\Schema(type="string", example="6A5JMHSC")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="정상 처리",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 nullable=true,
     *                 @OA\Property(property="eggtv_ticket_id", type="string", example="55", description="이용권 ID"),
     *                 @OA\Property(property="eggtv_ticket_type", type="string", example="0", description="이용권 유형(0=SUBSCRIPTION=기간 이용권,1=TIER_UPGRADE=구독 등급 업그레이드)"),
     *                 @OA\Property(property="subscription_tier", type="string", example="1", description="구독 티어(1=LITE=라이트,2=STANDARD=스탠다드,3=PLUS=플러스,4=PREMIUM=프리미엄)"),
     *                 @OA\Property(property="subscription_days", type="string", example="2", description="구독 기간 OR 업그레이드 적용 기간(단위: 일)"),
     *                 @OA\Property(property="eggtv_ticket_issuing_id", type="string", example="26", description="이용권 발행 ID"),
     *                 @OA\Property(property="eggtv_ticket_alias", type="string", example="라이트 이용권", description="이용권 별칭"),
     *                 @OA\Property(property="intended_use", type="string", example="2", description="사용 목적(0=CS=고객 보상,1=MARKETING=마케팅,2=QA_TEST=내부 테스트,255=EMPLOYEE_BENEFIT=임직원 복리후생)"),
     *                 @OA\Property(property="issue_description", type="string", example="이용권 발행 설명", description="이용권 발행 설명"),
     *                 @OA\Property(property="issue_date", type="string", example="2025-04-07 02:05:31", description="이용권 코드 발행 일자"),
     *                 @OA\Property(property="eggtv_ticket_code_id", type="string", example="1176", description="이용권 코드 ID"),
     *                 @OA\Property(property="eggtv_ticket_code", type="string", example="6A5JMHSC", description="이용권 코드"),
     *                 @OA\Property(property="expiry_date", type="string", example="2025-06-30", description="등록 만료 일자"),
     *                 @OA\Property(property="eggtv_ticket_code_status", type="string", example="1", description="이용권 코드 상태(0=DISABLED=비활성,1=ENABLED=활성)"),
     *                 @OA\Property(property="registration_count", type="string", example="10", description="등록 횟수"),
     *                 @OA\Property(property="max_registration_count", type="string", example="0", description="이용권 코드 1개 당 등록할 수 있는 최대 횟수"),
     *                 @OA\Property(property="use_count", type="string", example="0", description="사용 횟수"),
     *             ),
     *             @OA\Property(property="code", type="string", nullable=true, example=null),
     *             @OA\Property(property="message", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="인증 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="NOT_FOUND_MEMBER_INFO"),
     *             @OA\Property(property="message", type="string", example="회원정보를 찾을 수 없습니다.")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="조회 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="ENTER_SEARCH_CODE"),
     *             @OA\Property(property="message", type="string", example="검색할 코드를 입력해주세요.")
     *         )
     *     )
     * )
     */
    public function searchTicketCode()
    {
        try {
            $operatorId = $this->request->getVar('operatorId');
            $teamId = $this->request->getVar('teamId');
            if (!isset($operatorId) || !isset($teamId)) {
                return setResponseFormat($this->response, 'NOT_FOUND_MEMBER_INFO', null);
            }

            $code = $this->request->getVar('code');
            if (!isset($code)) {
                return setResponseFormat($this->response, 'ENTER_SEARCH_CODE', null);
            }

            $result = $this->spModel->executeSP('sp-op-eggtv_ticket_codes-ro-v1', 5, [$operatorId, $teamId, SERVER_ADDR, $code, $this->callDate]);
            return setResponseFormat($this->response, null, $result);
        } catch (Exception $e) {
            logException($e);
            return setResponseFormat($this->response, $e->getMessage(), null);
        }
    }

    /**
     * @OA\Get (
     *     path="/api/v1/retail_eggtv/registered",
     *     summary="이용권 코드를 등록한 회원 목록",
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
     *     @OA\Parameter(
     *         name="code",
     *         in="query",
     *         required=true,
     *         description="이용권 코드",
     *         @OA\Schema(type="string", example="G9NPHJAPSRDN")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="정상 처리",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 nullable=true,
     *                 @OA\Property(property="em_no", type="string", example="9992321", description="정회원 ID"),
     *                 @OA\Property(property="em_parent", type="string", example="고길동", description="부모명"),
     *                 @OA\Property(property="em_email", type="string", example="it@englishegg.co.kr", description="이메일"),
     *                 @OA\Property(property="register_date", type="string", example="2025-04-08", description="이용권 코드 등록 일자"),
     *                 @OA\Property(property="use_date", type="string", nullable=true, example=null, description="사용 일자"),
     *             ),
     *             @OA\Property(property="code", type="string", nullable=true, example=null),
     *             @OA\Property(property="message", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="인증 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="NOT_FOUND_MEMBER_INFO"),
     *             @OA\Property(property="message", type="string", example="회원정보를 찾을 수 없습니다.")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="조회 실패",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object", nullable=true, example=null),
     *             @OA\Property(property="code", type="string", example="ENTER_SEARCH_CODE"),
     *             @OA\Property(property="message", type="string", example="검색할 코드를 입력해주세요.")
     *         )
     *     )
     * )
     */
    public function registeredTicket()
    {
        try {
            $operatorId = $this->request->getVar('operatorId');
            $teamId = $this->request->getVar('teamId');
            if (!isset($operatorId) || !isset($teamId)) {
                return setResponseFormat($this->response, 'NOT_FOUND_MEMBER_INFO', null);
            }

            $code = $this->request->getVar('code');
            if (!isset($code)) {
                return setResponseFormat($this->response, 'EMPTY_SEARCH_CODE', null);
            }
            $result = $this->spModel->executeSP('sp-op-eggtv_ticket_code_registrations-ra-v1', 5, [$operatorId, $teamId, SERVER_ADDR, $code, $this->callDate]);
            return setResponseFormat($this->response, null, $result);
        } catch (Exception $e) {
            logException($e);
            return setResponseFormat($this->response, $e->getMessage(), null);
        }
    }
}