<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class ErrorMessages extends BaseConfig
{
    /**
     * @var array
     * @description [상태] + [주제] + [세부 정보(옵션)] 형태로 오류 코드를 생성합니다. (sp 메세지는 명세 그대로 사용합니다.)
     */
    public array $messages = [
        'DEFAULT_MSG' => [
            'development' => '오류가 발생했습니다. 자세한 내용은 관리자에게 문의하세요.',
            'stage' => '오류가 발생했습니다. 자세한 내용은 관리자에게 문의하세요.',
            'production' => '오류가 발생했습니다. 자세한 내용은 관리자에게 문의하세요.'
        ],
        'NOT_FOUND_OPERATOR_LOGIN_ID' => [ //sp-op-operator_credentials-ro-v1 || sp-op-auth_failures-c-v1 || sp-op-operator_login_otps-c-v1 || sp-op-email_verifications-c-v1
            'development' => '운영자 로그인 아이디가 없습니다.',
            'stage' => '운영자 로그인 아이디가 없습니다.',
            'production' => '오류가 발생했습니다. 입력하신 아이디를 확인해주세요.'
        ],
        'INACTIVE_OPERATOR' => [ //sp-op-operator_credentials-ro-v1
            'development' => '초대를 수락하지 않은 운영자입니다.',
            'stage' => '초대를 수락하지 않은 운영자입니다.',
            'production' => '초대를 수락하지 않은 계정입니다. 입력하신 이메일을 확인해주세요.'
        ],
        'DEACTIVATED_OPERATOR' => [ //sp-op-operator_credentials-ro-v1
            'development' => '비활성 상태의 운영자입니다.',
            'stage' => '비활성 상태의 운영자입니다.',
            'production' => '오류가 발생했습니다. 자세한 내용은 관리자에게 문의하세요.'
        ],
        'EXCEEDED_VERIFICATION_LIMIT' => [ //sp-op-operator_login_otps-ro-v1 || sp-op-email_verifications-ro-v1
            'development' => '확인 코드에 대한 검증 허용 횟수를 초과했습니다.',
            'stage' => '확인 코드에 대한 검증 허용 횟수를 초과했습니다.',
            'production' => '오류가 발생했습니다. 다시 한 번 시도해 주세요.'
        ],
        'INVALID_LOGIN_OTP' => [ //sp-op-operator_login_otps-ro-v1
            'development' => '로그인 OTP가 일치하지 않습니다.',
            'stage' => '로그인 OTP가 일치하지 않습니다.',
            'production' => '오류가 발생했습니다. 다시 한 번 시도해 주세요.'
        ],
        'DUPLICATED_REFRESH_TOKEN_SIGNATURE' => [ //sp-op-refresh_tokens-c-v1
            'development' => '이미 발행한 리프레시 토큰의 시그니처입니다.',
            'stage' => '이미 발행한 리프레시 토큰의 시그니처입니다.',
            'production' => '오류가 발생했습니다. 다시 한 번 시도해 주세요.'
        ],
        'NOT_FOUND_REFRESH_TOKEN' => [ //sp-op-refresh_tokens-ro-v1 || sp-op-refresh_tokens-u-v1 || sp-op-refresh_tokens-d-v1
            'development' => '리프레시 토큰이 없습니다.',
            'stage' => '리프레시 토큰이 없습니다.',
            'production' => '오류가 발생했습니다. 다시 한 번 시도해 주세요.'
        ],
        'NOT_FOUND_EMAIL_VERIFICATION_CODE' => [ //sp-op-email_verifications-ro-v1
            'development' => '확인 코드가 올바르지 않습니다.',
            'stage' => '확인 코드가 올바르지 않습니다.',
            'production' => '오류가 발생했습니다. 입력하신 인증번호를 확인해주세요.'
        ],
        'INSUFFICIENT_PRIVILEGE' => [ //sp-op-granted_privileges-ra-v1
            'development' => '권한이 없습니다.', //(impersonate)
            'stage' => '권한이 없습니다.', //(impersonate)
            'production' => '권한이 없습니다. 자세한 내용은 관리자에게 문의하세요.' // (impersonate)
        ],
        'NOT_FOUND_OPERATOR' => [ //sp-op-my_profiles-phone_number-u-v1 || sp-op-my_profiles-u-v1
            'development' => '운영자가 없습니다.',
            'stage' => '운영자가 없습니다.',
            'production' => '회원 정보가 존재하지 않습니다. 자세한 내용은 관리자에게 문의하세요.'
        ],
        'PHONE_NOT_OWNED_BY_USER' => [ //sp-op-my_profiles-phone_number-u-v1
            'development' => '본인 소유의 휴대폰이 아닙니다.',
            'stage' => '본인 소유의 휴대폰이 아닙니다.',
            'production' => '본인 명의의 휴대폰이 아닙니다. 입력하신 번호를 확인해주세요.'
        ],
        'INVALID_ARGUMENT' => [ //sp-op-teams-c-v1 || sp-op-team_operators-c-v1 || sp-op-team_operator_roles-u-v1 || sp-op-gift_policies-u-v1 || sp-op-promotions-u-v1
            'development' => '잘못된 입력입니다.', // '잘못된 입력입니다. (pTeamType)' || '잘못된 입력입니다. (pRoleName 오류)' || '잘못된 입력입니다. (no roles)' || '잘못된 입력입니다. (invalid roles)' || 'pSelectableLimit 값이 올바르지 않습니다.'
            'stage' => '잘못된 입력입니다.', // '잘못된 입력입니다. (pTeamType)' || '잘못된 입력입니다. (pRoleName 오류)' || '잘못된 입력입니다. (no roles)' || '잘못된 입력입니다. (invalid roles)' || 'pSelectableLimit 값이 올바르지 않습니다.'
            'production' => '오류가 발생했습니다. 입력하신 정보를 확인해주세요.' // '잘못된 입력입니다. (pTeamType)' || '잘못된 입력입니다. (no roles)' || '잘못된 입력입니다. (invalid roles)' || 'pSelectableLimit 값이 올바르지 않습니다.'
        ],
        'DUPLICATED_BIZ_REGISTRATION_NUMBER' => [ //sp-op-teams-c-v1 || sp-op-teams-duplicated_registration_number-ro-v1
            'development' => '이미 등록된 사업자등록번호 입니다.',
            'stage' => '이미 등록된 사업자등록번호 입니다.',
            'production' => '오류가 발생했습니다. 이미 등록된 사업자등록번호 입니다.'
        ],
        'INVALID_INVITATION_CODE' => [ //sp-op-team_operator_invitations-ro-v1 || sp-op-team_operator_activations-c-v2
            'development' => '초대 코드가 일치하지 않습니다.',
            'stage' => '초대 코드가 일치하지 않습니다.',
            'production' => '오류가 발생했습니다. 입력하신 정보를 확인해주세요.'
        ],
        'EMAIL_MISMATCH_WITH_USER' => [ //sp-op-team_operator_activations-c-v2
            'development' => '이메일 주소를 사용하고 있는 사람과 본인 정보가 일치하지 않습니다.',
            'stage' => '이메일 주소를 사용하고 있는 사람과 본인 정보가 일치하지 않습니다.',
            'production' => '오류가 발생했습니다. 입력하신 정보를 확인해주세요.',
        ],
        'INVALID_VERIFICATION_CODE' => [ //sp-op-operator_passphrase-c-v2
            'development' => '확인 코드가 일치하지 않습니다.',
            'stage' => '확인 코드가 일치하지 않습니다.',
            'production' => '오류가 발생했습니다. 입력하신 정보를 확인해주세요.',
        ],
        'ACTIVATION_CONDITIONS_NOT_MET' => [ //sp-op-teams-team_status-u-v1
//            'development' => '팀 활성화 조건을 만족하지 못합니다.',
//            'production' => '오류가 발생했습니다. 자세한 내용은 관리자에게 문의하세요.'
            'development' => '팀 활성화 조건을 만족하지 않아 불가합니다. 사업자등록번호, 사업자등록증 사본, 사업장 주소, 통장 계좌번호, 통장 사본이 입력되었는지 확인해주세요.',
            'stage' => '팀 활성화 조건을 만족하지 않아 불가합니다. 사업자등록번호, 사업자등록증 사본, 사업장 주소, 통장 계좌번호, 통장 사본이 입력되었는지 확인해주세요.',
            'production' => '팀 활성화 조건을 만족하지 않아 불가합니다. 사업자등록번호, 사업자등록증 사본, 사업장 주소, 통장 계좌번호, 통장 사본이 입력되었는지 확인해주세요.',
        ],
        'TEAM_ALREADY_HAS_OWNER' => [ //sp-op-team_operators-c-v1
            'development' => '이미 대표 운영자가 있는 팀입니다.',
            'stage' => '이미 대표 운영자가 있는 팀입니다.',
            'production' => '이미 대표 운영자가 있는 팀입니다.'
        ],
        'TEAM_HAS_NO_ADMIN' => [ //sp-op-team_operators-c-v1
            'development' => '아직 관리자가 없는 팀입니다.',
            'stage' => '아직 관리자가 없는 팀입니다.',
            'production' => '아직 관리자가 없는 팀입니다.'
        ],
        'DUPLICATED_TEAM_OPERATOR' => [ //sp-op-team_operators-c-v1
            'development' => '이미 등록한 팀 운영자입니다.',
            'stage' => '이미 등록한 팀 운영자입니다.',
            'production' => '이미 등록한 팀 운영자입니다.'
        ],
        'NOT_FOUND_TEAM_OPERATOR' => [ //sp-op-team_operator_invitations-d-v1 || sp-op-team_operators-d-v1
            'development' => '팀 운영자가 없습니다.',
            'stage' => '팀 운영자가 없습니다.',
            'production' => '팀 운영자가 없습니다.'
        ],
        'ALREADY_REGISTERED_TEAM_OPERATOR' => [ //sp-op-team_operator_invitations-d-v1
            'development' => '이미 등록된 팀 운영자입니다.',
            'stage' => '이미 등록된 팀 운영자입니다.',
            'production' => '이미 등록된 팀 운영자입니다.'
        ],
        'ADMIN_CANNOT_BE_DEACTIVATED' => [ //sp-op-team_operators-d-v1
            'development' => '관리자를 비활성화할 수 없습니다.',
            'stage' => '관리자를 비활성화할 수 없습니다.',
            'production' => '관리자를 비활성화할 수 없습니다.'
        ],
        'NOT_FOUND_TEAM' => [ //sp-op-team_operator_roles-u-v1 || sp-op-team_ownership-u-v1
            'development' => '팀이 없습니다.',
            'stage' => '팀이 없습니다.',
            'production' => '팀이 존재하지 않습니다.'
        ],
        'OWNER_ROLE_CANNOT_BE_MODIFIED' => [ //sp-op-team_operator_roles-u-v1
            'development' => '대표 운영자 역할은 임의로 변경할 수 없습니다.',
            'stage' => '대표 운영자 역할은 임의로 변경할 수 없습니다.',
            'production' => '대표 운영자 역할은 임의로 변경할 수 없습니다.'
        ],
        'NOT_FOUND_BOOK_COLLECTION' => [ //sp-op-products-c-v2
            'development' => '전집이 없습니다.',
            'stage' => '전집이 없습니다.',
            'production' => '전집이 없습니다.'
        ],
        'DUPLICATED_BOOK_COLLECTION_PRODUCT' => [ //sp-op-products-c-v2 || sp-op-duplicated_book_collection_products-ro-v1
            'development' => '이미 등록된 전집 구성입니다.',
            'stage' => '이미 등록된 전집 구성입니다.',
            'production' => '이미 등록된 전집 구성입니다.'
        ],
        'NOT_FOUND_PRODUCT' => [ //sp-op-product_prices-c-v1 || sp-op-gift_policies-c-v1 || sp-op-products-u-v1
            'development' => '상품이 없습니다.',
            'stage' => '상품이 없습니다.',
            'production' => '상품이 존재하지 않습니다.'
        ],
        'PERIOD_OVERLAP_WITH_EXISTING' => [ //sp-op-product_prices-c-v1 || sp-op-gift_policies-c-v1 || sp-op-promotions-c-v1
            'development' => '기간이 중복됩니다.',
            'stage' => '기간이 중복됩니다.',
            'production' => '기간이 중복됩니다.'
        ],
        'NOT_FOUND_PRICE' => [ //sp-op-product_prices-d-v1
            'development' => '가격이 없습니다.',
            'stage' => '가격이 없습니다.',
            'production' => '가격이 존재하지 않습니다.'
        ],
        'PRICE_CHANGE_ALREADY_APPLIED' => [ //sp-op-product_prices-d-v1
            'development' => '이미 가격 적용이 시작되었습니다.',
            'stage' => '이미 가격 적용이 시작되었습니다.',
            'production' => '이미 가격 적용이 시작되었습니다.'
        ],
        'MUST_DELETE_LAST_PRICE_RECORD_FIRST' => [ //sp-op-product_prices-d-v1
            'development' => '가장 마지막 가격 레코드를 먼저 삭제해야 합니다. (모든 판매사 가격)',
            'stage' => '가장 마지막 가격 레코드를 먼저 삭제해야 합니다. (모든 판매사 가격)',
            'production' => '가장 마지막 가격 레코드를 먼저 삭제해야 합니다. (모든 판매사 가격)'
        ],
        'NOT_FOUND_POLICY' => [ //sp-op-gift_policies-d-v1
            'development' => '정책이 없습니다.',
            'stage' => '정책이 없습니다.',
            'production' => '정책이 존재하지 않습니다.'
        ],
        'POLICY_ALREADY_APPLIED' => [ //sp-op-gift_policies-d-v1
            'development' => '이미 정책 적용이 시작되었습니다.',
            'stage' => '이미 정책 적용이 시작되었습니다.',
            'production' => '이미 정책 적용이 시작되었습니다.'
        ],
        'MUST_DELETE_LAST_POLICY_RECORD_FIRST' => [ //sp-op-gift_policies-d-v1
            'development' => '가장 마지막 정책 레코드를 먼저 삭제해야 합니다. (모든 판매사 정책)',
            'stage' => '가장 마지막 정책 레코드를 먼저 삭제해야 합니다. (모든 판매사 정책)',
            'production' => '가장 마지막 정책 레코드를 먼저 삭제해야 합니다. (모든 판매사 정책)'
        ],
        'INVALID_ARGUMENTS' => [ //sp-op-promotions-c-v1
            'development' => 'pProducts가 올바르지 않습니다.',
            'stage' => 'pProducts가 올바르지 않습니다.',
            'production' => 'pProducts가 올바르지 않습니다.'
        ],
        'NOT_FOUND_SUPPLIER' => [ //sp-op-promotions-c-v1
            'development' => '교재 공급사가 없습니다.',
            'stage' => '교재 공급사가 없습니다.',
            'production' => '교재 공급사가 존재하지 않습니다.'
        ],
        'NOT_FOUND_PROMOTION' => [ //sp-op-promotions-d-v1
            'development' => '프로모션이 없습니다.',
            'stage' => '프로모션이 없습니다.',
            'production' => '프로모션이 존재하지 않습니다.'
        ],
        'PROMOTION_ALREADY_APPLIED' => [ //sp-op-promotions-d-v1
            'development' => '이미 프로모션 적용이 시작되었습니다.',
            'stage' => '이미 프로모션 적용이 시작되었습니다.',
            'production' => '이미 프로모션 적용이 시작되었습니다.'
        ],
        'MUST_DELETE_LAST_PROMOTION_RECORD_FIRST' => [ //sp-op-promotions-d-v1
            'development' => '가장 마지막 프로모션 레코드를 먼저 삭제해야 합니다. (모든 판매사 프로모션)',
            'stage' => '가장 마지막 프로모션 레코드를 먼저 삭제해야 합니다. (모든 판매사 프로모션)',
            'production' => '가장 마지막 프로모션 레코드를 먼저 삭제해야 합니다. (모든 판매사 프로모션)'
        ],
        'INSUFFICIENT_TICKETS_LEFT' => [ //sp-op-performance_free_tickets-c-v1
            'development' => '잔여 티켓이 부족합니다.',
            'stage' => '잔여 티켓이 부족합니다.',
            'production' => '잔여 티켓이 부족합니다.'
        ],
        'NOT_FOUND_PERFORMANCE_TOUR_SCHEDULE' => [ //sp-op-performance_free_tickets-c-v1
            'development' => '공연 스케쥴이 없습니다.',
            'stage' => '공연 스케쥴이 없습니다.',
            'production' => '공연 스케쥴이 존재하지 않습니다.'
        ],
        'DUPLICATED_EGGTV_TICKET_CONDITION' => [ //sp-op-eggtv_tickets-c-v2
            'development' => '이미 등록된 에그TV 이용권 조건입니다.',
            'stage' => '이미 등록된 에그TV 이용권 조건입니다.',
            'production' => '이미 동일한 조건의 에그TV 이용권이 있습니다.'
        ],
        'ALREADY_ISSUED_EGGTV_TICKET' => [ //sp-op-eggtv_tickets-d-v1
            'development' => '발행 이력이 있는 에그TV 이용권입니다.',
            'stage' => '발행 이력이 있는 에그TV 이용권입니다.',
            'production' => '발행 이력이 있어 삭제를 실패했습니다.'
        ],
        'NOT_FOUND_EGGTV_TICKET' => [ //sp-op-eggtv_tickets-d-v1 || sp-op-eggtv_ticket_issuings-c-v2
            'development' => '에그TV 이용권이 없습니다. (pEggtvTicketId 값이 존재하지 않습니다.)',
            'stage' => '에그TV 이용권이 없습니다. (pEggtvTicketId 값이 존재하지 않습니다.)',
            'production' => '존재하지 않는 에그TV 이용권입니다.'
        ],
        'DUPLICATED_EGGTV_TICKET_CODE' => [ //sp-op-eggtv_ticket_issuings-c-v2
            'development' => '이미 발행한 에그TV 이용권 코드입니다.',
            'stage' => '이미 발행한 에그TV 이용권 코드입니다.',
            'production' => '이미 동일한 코드로 발행한 에그TV 이용권이 있습니다.'
        ],
        'DUPLICATED_COUPON_CONDITION' => [ //sp-op-coupons-c-v1
            'development' => '이미 등록된 할인 쿠폰 조건입니다.',
            'stage' => '이미 등록된 할인 쿠폰 조건입니다.',
            'production' => '이미 동일한 조건의 에그TV 할인 쿠폰이 있습니다.'
        ],
        'ALREADY_ISSUED_COUPON' => [ //sp-op-coupons-d-v1
            'development' => '발행 이력이 있는 할인 쿠폰입니다.',
            'stage' => '발행 이력이 있는 할인 쿠폰입니다.',
            'production' => '발행 이력이 있는 할인 쿠폰입니다.'
        ],
        'NOT_FOUND_COUPON' => [ //sp-op-coupons-d-v1 || sp-op-coupon_issuings-c-v1
            'development' => '할인 쿠폰이 없습니다. (pCouponId 값이 존재하지 않습니다.)',
            'stage' => '할인 쿠폰이 없습니다. (pCouponId 값이 존재하지 않습니다.)',
            'production' => '할인 쿠폰이 존재하지 않습니다.'
        ],
        'DUPLICATED_COUPON_CODE' => [ //sp-op-coupon_issuings-c-v1
            'development' => '이미 발행한 할인 쿠폰 코드입니다.',
            'stage' => '이미 발행한 할인 쿠폰 코드입니다.',
            'production' => '이미 발행한 할인 쿠폰 코드입니다.'
        ],
        'NOT_FOUND_EGGTV_TICKET_CODE' => [ // sp-op-eggtv_ticket_code_registrations-d-v1
            'development' => '이용권 코드가 없습니다.',
            'stage' => '이용권 코드가 없습니다.',
            'production' => '이용권 코드가 없습니다.'
        ],
        'EXPIRED_EGGTV_TICKET_CODE' => [ // sp-op-eggtv_ticket_code_registrations-d-v1
            'development' => '기간이 만료된 이용권 코드입니다.',
            'stage' => '기간이 만료된 이용권 코드입니다.',
            'production' => '기간이 만료된 이용권 코드입니다.'
        ],
        'EXISTS_HIGHER_TIER_RECURRING_SUBSCRIPTION' => [ // sp-op-eggtv_ticket_code_registrations-d-v1
            'development' => '상위 티어의 정기 구독이 존재합니다.',
            'stage' => '상위 티어의 정기 구독이 존재합니다.',
            'production' => '상위 티어의 정기 구독이 존재합니다.'
        ],
        'NOT_FOUND_COUPON_CODE' => [
            'development' => '할인권 코드가 없습니다.',
            'stage' => '할인권 코드가 없습니다.',
            'production' => '할인권 코드가 없습니다.'
        ],
        'EXPIRED_COUPON_CODE' => [
            'development' => '기간이 만료된 할인권 코드입니다.',
            'stage' => '기간이 만료된 할인권 코드입니다.',
            'production' => '기간이 만료된 할인권 코드입니다.'
        ],
        'COUPON_CODE_ALREADY_USED' => [
            'development' => '이미 사용한 할인권 코드입니다.',
            'stage' => '이미 사용한 할인권 코드입니다.',
            'production' => '이미 사용한 할인권 코드입니다.'
        ],

        // custom
        'EXPIRED_REFRESH_TOKEN' => [ //custom message
            'development' => '토큰이 만료되었습니다.',
            'stage' => '토큰이 만료되었습니다.',
            'production' => '로그인 정보가 만료되었습니다. 다시 로그인해 주세요.'
        ],
        'INVALID_MEMBER_CREDENTIALS' => [ //custom message
            'development' => '회원정보가 올바르지 않습니다.',
            'stage' => '회원정보가 올바르지 않습니다.',
            'production' => '아이디 또는 비밀번호가 잘못되었습니다. 아이디와 비밀번호를 정확하게 입력해 주세요.'
        ],
        'NOT_FOUND_GE_MEMBER' => [ //custom message
            'development' => '회원정보가 존재하지 않습니다.',
            'stage' => '회원정보가 존재하지 않습니다.',
            'production' => '회원정보가 올바르지 않습니다. 다시 확인해 주세요.'
        ],
        'MISSING_DATA_REQUIRED' => [ //custom message
            'development' => '필수 데이터가 존재하지 않습니다.',
            'stage' => '필수 데이터가 존재하지 않습니다.',
            'production' => '필수 데이터가 존재하지 않습니다.'
        ],
        'PASSWORD_CHECK_REQUIRED' => [
            'development' => '비밀번호 확인 없이 접근했습니다.',
            'stage' => '비밀번호 확인 없이 접근했습니다.',
            'production' => '비밀번호 확인 후 다시 시도해주세요.'
        ],
        'FAILED_SEND' => [ //custom message
            'development' => '전송에 실패했습니다.',
            'stage' => '전송에 실패했습니다.',
            'production' => '전송에 실패했습니다.'
        ],
        'INCORRECT_PASSWORD' => [ //custom message
            'development' => '비밀번호가 올바르지 않습니다.',
            'stage' => '비밀번호가 올바르지 않습니다.',
            'production' => '비밀번호가 올바르지 않습니다.'
        ],
        'INVALID_ID_MEMBER' => [ //custom message
            'development' => 'memberId가 유효하지 않습니다.',
            'stage' => 'memberId가 유효하지 않습니다.',
            'production' => '다시 로그인 해주세요.',
        ],
        'VIOLATION_DATA_INTEGRITY' => [ //custom message
            'development' => '무결성 값이 다릅니다. 데이터가 변경된 것이 아닌지 확인 바랍니다.',
            'stage' => '무결성 값이 다릅니다. 데이터가 변경된 것이 아닌지 확인 바랍니다.',
            'production' => '본인인증 다시 시도해주세요.'
        ],
        'INVALID_VALUE_SESSION' => [ //custom message
            'development' => '세션값이 다릅니다. 올바른 경로로 접근하시기 바랍니다.',
            'stage' => '세션값이 다릅니다. 올바른 경로로 접근하시기 바랍니다.',
            'production' => '본인인증 다시 시도해주세요.'
        ],
        'FAILED_AUTHENTICATION' => [ //custom message
            'development' => '본인인증에 실패했습니다.',
            'stage' => '본인인증에 실패했습니다.',
            'production' => '본인인증에 실패했습니다.',
        ],
        'FAILURE_COUNT_OVER_VERIFICATION' => [ //custom message
            'development' => '인증요청 제한 횟수를 초과했습니다. 재전송 버튼을 눌러주세요.',
            'stage' => '인증요청 제한 횟수를 초과했습니다. 재전송 버튼을 눌러주세요.',
            'production' => '인증요청 제한 횟수를 초과했습니다. 재전송 버튼을 눌러주세요.'
        ],
        'WRONG_VERIFICATION_CODE' => [ //custom message
            'development' => '인증코드가 올바르지 않습니다. 다시 입력해주세요.',
            'stage' => '인증코드가 올바르지 않습니다. 다시 입력해주세요.',
            'production' => '인증코드가 올바르지 않습니다. 다시 입력해주세요.'
        ],
        'MISSING_PASSWORD_INPUT' => [ //custom message
            'development' => '비밀번호를 다시 입력해주세요.',
            'stage' => '비밀번호를 다시 입력해주세요.',
            'production' => '비밀번호를 다시 입력해주세요.'
        ],
        'NOT_FOUND_MEMBER_INFO' => [ //custom message
            'development' => '회원정보를 찾을 수 없습니다.',
            'stage' => '회원정보를 찾을 수 없습니다.',
            'production' => '회원정보를 찾을 수 없습니다.'
        ],
        'INVALID_EMAIL_OR_ROLE' => [ //custom message
            'development' => '이메일 또는 역할을 확인해주세요.',
            'stage' => '이메일 또는 역할을 확인해주세요.',
            'production' => '이메일 또는 역할을 확인해주세요.'
        ],
        'MISSING_REQUIRED_DATA' => [ //custom message
            'development' => '데이터를 입력해주세요.',
            'stage' => '데이터를 입력해주세요.',
            'production' => '데이터를 입력해주세요.'
        ],
        'MISSING_PHONE_NUMBER' => [ //custom message
            'development' => '번호가 입력되지 않았습니다. 다시 시도해주세요.',
            'stage' => '번호가 입력되지 않았습니다. 다시 시도해주세요.',
            'production' => '번호가 입력되지 않았습니다. 다시 시도해주세요.'
        ],
        'FAILED_FILE_VERIFICATION' => [ //custom message
            'development' => '파일을 확인 후 다시 시도해주세요.',
            'stage' => '파일을 확인 후 다시 시도해주세요.',
            'production' => '파일을 확인 후 다시 시도해주세요.'
        ],
        'INVALID_PARTNER_TYPE_AND_IMAGE_PATH' => [ //custom message
            'development' => '파트너사 유형과 이미지 경로를 다시 시도해주세요.',
            'stage' => '파트너사 유형과 이미지 경로를 다시 시도해주세요.',
            'production' => '파트너사 유형과 이미지 경로를 다시 시도해주세요.'
        ],
        'EMPTY_IMAGE_PATH' => [ //custom message
            'development' => '이미지 경로가 비어있습니다. 다시 확인해주세요.',
            'stage' => '이미지 경로가 비어있습니다. 다시 확인해주세요.',
            'production' => '이미지 경로가 비어있습니다. 다시 확인해주세요.'
        ],
        'MISSING_PASSWORD_INPUT_CHECK' => [ //custom message
            'development' => '비밀번호가 입력되지 않았습니다. 다시 확인해주세요.',
            'stage' => '비밀번호가 입력되지 않았습니다. 다시 확인해주세요.',
            'production' => '비밀번호가 입력되지 않았습니다. 다시 확인해주세요.'
        ],
        'INVALID_CODE_VALUE' => [ //custom message
            'development' => '코드 값을 확인해주세요.',
            'stage' => '코드 값을 확인해주세요.',
            'production' => '코드 값을 확인해주세요.'
        ],
        'ENTER_SEARCH_CODE' => [ //custom message
            'development' => '검색할 코드를 입력해주세요.',
            'stage' => '검색할 코드를 입력해주세요.',
            'production' => '검색할 코드를 입력해주세요.'
        ],
        'EMPTY_SEARCH_CODE' => [ //custom message
            'development' => '코드를 찾을 수 없습니다.',
            'stage' => '코드를 찾을 수 없습니다.',
            'production' => '코드를 찾을 수 없습니다.'
        ],
        'NEW_OPERATOR_NOT_FOUND' => [ //custom message
            'development' => '새 운영자를 찾을 수 없습니다. 다시 시도해 주세요.',
            'stage' => '새 운영자를 찾을 수 없습니다. 다시 시도해 주세요.',
            'production' =>'새 운영자를 찾을 수 없습니다. 다시 시도해 주세요.'
        ],
        'NOT_FOUND_SESSION' => [ //custom message
            'development' => '세션이 만료되었습니다.',
            'stage' => '세션이 만료되었습니다.',
            'production' => '세션이 존재하지 않습니다. 다시 로그인 해주세요.',
        ],
        'EMPTY_VALUE' => [ //custom message
            'development' => '필수값이 없습니다.',
            'stage' => '필수값이 없습니다.',
            'production' => '입력 값을 확인해주세요..',
        ],
    ];
}
