DROP DATABASE IF EXISTS `medibox`;
CREATE DATABASE `medibox` DEFAULT character set utf8;
USE medibox;

create user 'medibox'@'localhost' identified by 'code0809_';
grant all privileges on medibox.* to 'medibox'@'localhost';

-- 관리자
create table admin_info
(
    admin_seqno bigint auto_increment
        primary key,
    admin_id    varchar(200)      not null,
    admin_pw    varchar(256)      not null,
    admin_name    varchar(50)      not null,
    delete_yn    varchar(1)      not null default 'N',
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
create index admin_info__index_1
    on admin_info (admin_id);

insert into admin_info (admin_id, admin_pw, admin_name, delete_yn) values ('dev.codeidea@gmail.com','code0809_','Codeidea 개발자','N');
insert into admin_info (admin_id, admin_pw, admin_name, delete_yn) values ('admin','4321','메디박스 관리자','N');

-- 사용자
create table user_info
(
    user_seqno bigint auto_increment
        primary key,
    user_phone    varchar(20)      not null,
    user_pw    varchar(256)      not null,
    user_name    varchar(50)      not null,
    memo    varchar(500)      null, -- 고객 특이사항
    event_yn    varchar(1)      not null default 'N',
    approve_yn    varchar(1)      not null default 'N',
    delete_yn    varchar(1)      not null default 'N',
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
create index user_info__index_1
    on user_info (user_phone);

-- alter table user_info add column memo varchar(500) null;

alter table user_info add column gender varchar(1) default 'M';
alter table user_info add column recommended_shop varchar(200);
alter table user_info add column recommended_code varchar(100);
alter table user_info add column push_yn    varchar(1)      not null default 'N';
alter table user_info add column email_yn    varchar(1)      not null default 'N';
alter table user_info add column sns_yn    varchar(1)      not null default 'N';

alter table user_info add column naver_id    varchar(300);
alter table user_info add column kakao_id    varchar(300);
alter table user_info add column google_id    varchar(300);


-- 포인트(종류) 마스터 테이블
create table point_info
(
    point_seqno bigint auto_increment
        primary key,
    point_type   varchar(2)      not null,
    point_name    varchar(50)      not null,
    delete_yn    varchar(1)      not null default 'N',
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
create index point_info__index_1
    on point_info (point_type);

insert into point_info (point_type, point_name, delete_yn) values ('P','포인트','N');
insert into point_info (point_type, point_name, delete_yn) values ('K','패키지','N');
insert into point_info (point_type, point_name, delete_yn) values ('S1','통합정액권','N');
insert into point_info (point_type, point_name, delete_yn) values ('S2','네일정액권','N');
insert into point_info (point_type, point_name, delete_yn) values ('S3','발몽정액권','N');
insert into point_info (point_type, point_name, delete_yn) values ('S4','포레스타정액권','N');


-- 사용자 - 포인트, 정액권, 패키지 
create table user_point
(
    user_point_seqno bigint auto_increment
        primary key,
    user_seqno    bigint      not null,
    point_type   varchar(2)      not null, -- P: 포인트, S1-4: 통합/네일/발몽/포레스타 정액권, K: 패키지
    point    int      default 0,
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
create index user_point__index_1
    on user_point (user_seqno);
-- 사용자 - 포인트/정액권/패키지 사용 내역
create table user_point_hst
(
    user_point_hst_seqno bigint auto_increment
        primary key,
    admin_seqno    bigint      not null,
    user_seqno    bigint      not null,
    product_seqno    bigint      null,
    shop_name    varchar(200)      null, -- 상품 대표명 (product_seqno 가 없는 경우)
    product_name    varchar(200)      null, -- 상품 대표명 (product_seqno 가 없는 경우)
    point_type   varchar(2)      not null, -- P: 포인트, S1-4: 통합/네일/발몽/포레스타 정액권, K: 패키지, N: 직접 입력
    hst_type   varchar(1)      not null, -- U: 사용, R: 환불, S: 충전
    admin_name    varchar(50)      null, -- 담당자 명
    refund_point_hst_seqno bigint null, -- 환불 seqno
    point    int      default 0,
    memo   varchar(300)      null, -- 사유
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
create index user_point_hst__index_1
    on user_point_hst (user_seqno);

alter table user_point_hst add column calculate varchar(1) default '+'; -- 포인트 차감자
alter table user_point_hst add column canceled varchar(1) default 'N'; -- hst_type 상태값에 대한 취소 여부 (사용/환불/충전 취소)
alter table user_point_hst add column approved varchar(1) default 'N'; -- 승인 여부

-- 사용자 패키지 구매/환불 가능 여부
create table user_package
(
    user_package_seqno bigint auto_increment
        primary key,
    user_seqno    bigint      not null,
    hst_type   varchar(1)      not null, -- U: 사용, R: 환불, S: 충전
    allow_refund   varchar(1)      not null, -- 환불가능여부 Y / N
    deleted   varchar(1)      not null, -- 환불처리된, 삭제여부 Y / N
    point    int      default 0,
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- 상품 가격 정보
create table product
(
    product_seqno bigint auto_increment
        primary key,
    point_type   varchar(2)      not null, -- P: 포인트, S1-4: 통합/네일/발몽/포레스타 정액권, K: 패키지
    type_name   varchar(200)      not null, -- 명칭
    service_name   varchar(200)      not null,
    service_sub_name   varchar(200)      null,
    price    int      default 0,
    return_point    int      default 0,
    offline_type   varchar(1)      not null, -- X: 포인트 상품, O: 샵 상품

    step_type    int      default 0, -- 스텝 그룹 구분 0:없음, 1: 일반 직원급, 2: 실장급, 3: 부원장급, 4: 원장급
    orders    int      default 0, -- 노출 순서
    delete_yn   varchar(1)      not null default 'N', -- 삭제여부

    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- alter table product add column delete_yn varchar(1) default 'N'; 

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'S3', '발몽스파','MINISH SPECIAL', '90분', 300000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'S3', '발몽스파','MINISH SPECIAL', '120분', 450000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 10, 0, 'S3', '발몽스파','하이드레이션', '30분', 140000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 11, 0, 'S3', '발몽스파','하이드레이션', '60분', 210000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 12, 0, 'S3', '발몽스파','하이드레이션', '90분', 280000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 13, 0, 'S3', '발몽스파','하이드레이션', '120분', 440000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 20, 0, 'S3', '발몽스파','에너지', '30분', 140000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 21, 0, 'S3', '발몽스파','에너지', '60분', 210000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 22, 0, 'S3', '발몽스파','에너지', '90분', 280000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 23, 0, 'S3', '발몽스파','에너지', '120분', 440000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 30, 0, 'S3', '발몽스파','레디언스', '30분', 140000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 31, 0, 'S3', '발몽스파','레디언스', '60분', 210000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 32, 0, 'S3', '발몽스파','레디언스', '90분', 280000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 33, 0, 'S3', '발몽스파','레디언스', '120분', 440000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 40, 0, 'S3', '발몽스파','라인&볼륨', '30분', 140000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 41, 0, 'S3', '발몽스파','라인&볼륨', '60분', 210000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 42, 0, 'S3', '발몽스파','라인&볼륨', '90분', 280000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 43, 0, 'S3', '발몽스파','라인&볼륨', '120분', 440000, 0);

-- insert into product (offline_typorders, step_type, e, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y1, 0, ', 'S3', '발몽스파','마제스티으', '30분', 210000, 0);
-- insert into product (offline_typorders, step_type, e, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y1, 0, ', 'S3', '발몽스파','마제스티으', '120분', 586000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 50, 0, 'S3', '발몽스파','MINISH TOUCH', '30분', 160000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 51, 0, 'S3', '발몽스파','MINISH TOUCH', '60분', 240000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 52, 0, 'S3', '발몽스파','MINISH TOUCH', '90분', 350000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 53, 0, 'S3', '발몽스파','MINISH TOUCH', '120분', 460000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 60, 0, 'S3', '발몽스파','마더 투 비(임산부)', '60분', 263000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 61, 0, 'S3', '발몽스파','마더 투 비(임산부)', '90분', 346000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'S2', '바라는네일', '베이직케어', null, 100000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'S2', '바라는네일', '베이직케어 네일&패디&각질', null, 250000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 3, 0, 'S2', '바라는네일', '베이직 젤네일&패디젤', null, 250000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 4, 'S4', '포레스타블랙','CUT-원장', '60분', 181500, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 3, 'S4', '포레스타블랙','CUT-부원장', '60분', 121000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 3, 2, 'S4', '포레스타블랙','CUT-실장', '60분', 108900, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 10, 4, 'S4', '포레스타블랙','DRY-원장', '40분', 121000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 11, 3, 'S4', '포레스타블랙','DRY-부원장', '40분', 108900, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 12, 2, 'S4', '포레스타블랙','DRY-실장', '40분', 96800, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 20, 0, 'S4', '포레스타블랙','PERM', null, 363000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 30, 0, 'S4', '포레스타블랙','컬러', null, 242000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 40, 0, 'S4', '포레스타블랙','두피케어 + 스피드 모발케어', null, 242000, 0);

-- 딥 포커스
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'P5', '딥포커스', 'classic', '40분', 100000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'P5', '딥포커스', 'luxury', '60분', 200000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 3, 0, 'P5', '딥포커스', 'special', '120분', 300000, 0);

-- 미니쉬 스파
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'P6', '미니쉬 스파', '구강 종합 검진', null, 480000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'P6', '미니쉬 스파', '치아튼튼 (4회)', null, 800000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 3, 0, 'P6', '미니쉬 스파', '잇몸튼튼 (4회)', null, 600000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 4, 0, 'P6', '미니쉬 스파', '미니쉬플러스 케어 (4회)', null, 600000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 5, 0, 'P6', '미니쉬 스파', '임플란트플러스 케어 (4회)', null, 400000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 6, 0, 'P6', '미니쉬 스파', '평생구강건강관리 (회당)', null, 150000, 0);

-- 미니쉬 도수
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'P7', '미니쉬 도수', 'classic', '40분', 100000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'P7', '미니쉬 도수', 'luxury', '90분', 350000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 3, 0, 'P7', '미니쉬 도수', 'special', '120분', 450000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 1, 0, 'K', '미니쉬 패키지','20만원', '패키지', 200000, 200000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 2, 0, 'K', '미니쉬 패키지','50만원', '패키지', 500000, 500000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 3, 0, 'K', '미니쉬 패키지','100만원', '패키지', 1000000, 1000000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 4, 0, 'K', '미니쉬 패키지','150만원', '패키지', 1500000, 1500000);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 1, 0, 'S2', '미니쉬 라운지 정액권','네일 정액권', '100만원', 1000000, 1050000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 2, 0, 'S2', '미니쉬 라운지 정액권','네일 정액권', '200만원', 2000000, 2200000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 3, 0, 'S2', '미니쉬 라운지 정액권','네일 정액권', '300만원', 3000000, 3450000);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 1, 0, 'S3', '미니쉬 라운지 정액권','발몽스파 정액권', '200만원', 2000000, 2400000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 2, 0, 'S3', '미니쉬 라운지 정액권','발몽스파 정액권', '300만원', 3000000, 3750000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 3, 0, 'S3', '미니쉬 라운지 정액권','발몽스파 정액권', '500만원', 5000000, 6750000);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 1, 0, 'S4', '미니쉬 라운지 정액권','포레스타 정액권', '100만원', 1000000, 1150000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 2, 0, 'S4', '미니쉬 라운지 정액권','포레스타 정액권', '200만원', 2000000, 2400000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 3, 0, 'S4', '미니쉬 라운지 정액권','포레스타 정액권', '300만원', 3000000, 3750000);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 1, 0, 'S1', '미니쉬 라운지 정액권','통합 정액권', '300만원', 3000000, 3300000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 2, 0, 'S1', '미니쉬 라운지 정액권','통합 정액권', '500만원', 5000000, 5750000);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('N', 3, 0, 'S1', '미니쉬 라운지 정액권','통합 정액권', '1000만원', 10000000, 12000000);

alter table product add column delete_yn varchar(1) default 'N'; 
update product set delete_yn = 'Y' where product_seqno in (40, 41,42,43,44,45);
update product set delete_yn = 'Y' where product_seqno in (25,26,27);
commit;
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'P6', '미니쉬 스파', 'BASIC', '1시간', 100000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 1, 0, 'S2', '바라는네일', '베이직케어-손기본케어', '60분-남자', 48400, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'S2', '바라는네일', '베이직케어-손기본케어', '60분-여자', 36300, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 3, 0, 'S2', '바라는네일', '베이직케어-손기본케어', '90분', 72600, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 10, 0, 'S2', '바라는네일', '베이직케어-발기본케어', '60분-남자', 72600, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 11, 0, 'S2', '바라는네일', '베이직케어-발기본케어', '60분-여자', 60500, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 12, 0, 'S2', '바라는네일', '베이직케어-발기본케어', '90분', 121000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 20, 0, 'S2', '바라는네일', '젤-젤네일아트', '90분', 96800, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 30, 0, 'S2', '바라는네일', '젤-젤패디아트', '90분', 121000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 40, 0, 'S2', '바라는네일', '젤-젤제거', '30분', 36300, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 50, 0, 'S2', '바라는네일', '젤-젤아트(네일&패디)', '120분', 121000, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 60, 0, 'S2', '바라는네일', '각질관리-각질1단계', '30분', 96800, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 61, 0, 'S2', '바라는네일', '각질관리-각질2단계', '40분', 133100, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 62, 0, 'S2', '바라는네일', '각질관리-각질3단계', '50분', 169400, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 63, 0, 'S2', '바라는네일', '각질관리-각질4단계', '60분', 217800, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 70, 0, 'S2', '바라는네일', '문제성 특수관리-물어뜯는손톱', '120분', 193600, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 80, 0, 'S2', '바라는네일', '문제성 특수관리-파고드는발톱', '100분-1ea', 181500, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 81, 0, 'S2', '바라는네일', '문제성 특수관리-파고드는발톱', '100분-2ea', 242000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 82, 0, 'S2', '바라는네일', '문제성 특수관리-파고드는발톱', '120분-1ea', 240900, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 83, 0, 'S2', '바라는네일', '문제성 특수관리-파고드는발톱', '120분-2ea', 350900, 0);

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 90, 0, 'S2', '바라는네일', '멤버쉽서비스-베이직케어', '90분', 100000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 91, 0, 'S2', '바라는네일', '멤버쉽서비스-베이직케어/네일+패디+각질', '120분', 250000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 92, 0, 'S2', '바라는네일', '멤버쉽서비스-베이직젤네일+젤패디', '180분', 250000, 0);

commit;

UPDATE `medibox`.`product` SET `type_name` = 'BASIC-포커스 비전케어' WHERE (`product_seqno` = '37');
UPDATE `medibox`.`product` SET `type_name` = 'LUXURY-딥포커스 비전케어' WHERE (`product_seqno` = '38');
UPDATE `medibox`.`product` SET `type_name` = 'SPECIAL-딥포커스 아이테라피' WHERE (`product_seqno` = '39');

UPDATE `medibox`.`product` SET `delete_yn` = 'Y' WHERE (`product_seqno` = '46');
UPDATE `medibox`.`product` SET `delete_yn` = 'Y' WHERE (`product_seqno` = '47');
UPDATE `medibox`.`product` SET `delete_yn` = 'Y' WHERE (`product_seqno` = '48');

UPDATE `medibox`.`product` SET `type_name` = 'BAISIC-미니쉬 스파' WHERE (`product_seqno` = '65');
UPDATE `medibox`.`product` SET `service_sub_name` = '180분' WHERE (`product_seqno` = '34');
UPDATE `medibox`.`product` SET `service_sub_name` = '120분' WHERE (`product_seqno` = '35');
UPDATE `medibox`.`product` SET `service_sub_name` = '90분' WHERE (`product_seqno` = '36');

INSERT INTO `medibox`.`admin_info` (`admin_seqno`, `admin_id`, `admin_pw`, `admin_name`, `delete_yn`) VALUES ('3', 'admin1', '4321!!', '메디박스 관리자1', 'N');
INSERT INTO `medibox`.`admin_info` (`admin_seqno`, `admin_id`, `admin_pw`, `admin_name`, `delete_yn`) VALUES ('4', 'admin2', '4321@@', '메디박스 관리자2', 'N');
INSERT INTO `medibox`.`admin_info` (`admin_seqno`, `admin_id`, `admin_pw`, `admin_name`, `delete_yn`) VALUES ('5', 'admin3', '4321##', '메디박스 관리자3', 'N');
INSERT INTO `medibox`.`admin_info` (`admin_seqno`, `admin_id`, `admin_pw`, `admin_name`, `delete_yn`) VALUES ('6', 'admin4', '4321$$', '메디박스 관리자4', 'N');
INSERT INTO `medibox`.`admin_info` (`admin_seqno`, `admin_id`, `admin_pw`, `admin_name`, `delete_yn`) VALUES ('7', 'admin5', '4321%%', '메디박스 관리자5', 'N');
INSERT INTO `medibox`.`admin_info` (`admin_seqno`, `admin_id`, `admin_pw`, `admin_name`, `delete_yn`) VALUES ('8', 'admin6', '4321**', '메디박스 관리자6', 'N');

insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 2, 0, 'P6', '미니쉬 스파', 'BASIC', '1시간-4회', 300000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 10, 0, 'P6', '미니쉬 스파', 'LUXURY-건치백세 패키지', '1시간-1회', 100000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 11, 0, 'P6', '미니쉬 스파', 'LUXURY-건치백세 패키지', '1시간-2회', 150000, 0);
insert into product (offline_type, orders, step_type, point_type, service_name, type_name, service_sub_name, price, return_point) values ('Y', 12, 0, 'P6', '미니쉬 스파', 'LUXURY-건치백세 패키지', '1시간-4회', 300000, 0);

commit;



alter table admin_info add column admin_type varchar(1) default 'A'; -- A 최고관리자, P 제휴사
-- 제휴사 관리
create table partner
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null, -- 등록 관리자

    cop_name   varchar(200)      not null, 
    cop_no   varchar(20)      not null, 
    cop_file   varchar(200)      null, 
    cop_phone    varchar(20)      null,
    online_order_business_no   varchar(30)      not null, 
    online_order_business_file   varchar(200)      null, 

    director_name   varchar(200)      not null, 
    director_phone    varchar(20)      null,
    director_email    varchar(50)      null,
    director_seqno bigint not null, -- admin_seqno 제휴 관리자.

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- 매장 정보
create table store
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null, -- 등록 관리자
    name   varchar(200)      not null, 
    phone    varchar(20)      null,
    address    varchar(300)      null,
    address_detail    varchar(300)      null,
    zipcode    varchar(7)      null,
    info   text      null, 
    img1    varchar(200)      null,
    img2    varchar(200)      null,
    img3    varchar(200)      null,
    img4    varchar(200)      null,
    img5    varchar(200)      null,
    in_manager   varchar(1)      not null, -- 매니저 예약 여부 Y / N
    manager_type   text      null, -- 매니저 구분 (list { 원장,매니저 })
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- (예약) 매장별 매니저 정보
-- (예약) 고객-매장 매니저 예약 정보
create table reservation
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      null, -- 
    partner_seqno bigint not null, -- 해당 제휴사
    store_seqno    bigint      not null, -- 해당 매장
    manager_seqno    bigint      null, -- 해당 디자이너 (없는 매장도 있음)
    user_seqno    bigint      not null, -- 등록 고객
    in_manager   varchar(1)      not null, -- 예약 상태 (Reservation 예약완료, user-do-Not-entered 예약불이행, Cancel 예약취소, user-Entered 고객입장, Done 서비스완료)
    -- 아이콘 표기 여부
    use_icon_important   varchar(1)      not null, -- 중요고객 여부 Y / N
    use_icon_phone   varchar(1)      not null, -- 전화표기 여부 Y / N
    use_custom_color   varchar(1)      not null, -- 색상선택 여부 Y / N
    -- 
    custom_color   varchar(7)      null, -- #000000
    estimated_time   varchar(5)      null, -- 예상 소요시간 00:00
    start_dt        datetime  not null,
    end_dt        datetime  not null,

    memo varchar(500) null,
    apply_on_mobile   varchar(1)      not null, -- 현장/모바일 등록 여부

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

create table reservation_product_grp
(
    seqno bigint auto_increment primary key,
    reservation_seqno    bigint      not null, -- 
    product_seqno bigint not null, -- 

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (예약) 환경 설정

create table reservation_config
(
    seqno bigint auto_increment primary key,
    partner_seqno bigint not null, -- 해당 제휴사
    store_seqno    bigint      not null, -- 해당 매장

    product_seqno bigint not null, -- 

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (예약) 문의
create table reservation_counsel
(
    seqno bigint auto_increment primary key,
    partner_seqno bigint not null, -- 해당 제휴사
    store_seqno    bigint      not null, -- 해당 매장
    user_seqno    bigint      not null, -- 해당 매장
    
    question text null, -- 
    answer text null, -- 
    answered   varchar(1)      not null, -- 답변 여부 Y / N

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- (쿠폰) 쿠폰
create table coupon
(
    seqno bigint auto_increment
        primary key,
    -- 적용 제휴사 그룹 (0이면 전부 적용)
    coupon_partner_grp_seqno bigint not null, -- 해당 제휴사
    name   varchar(200)      not null, -- 쿠폰명
    context   varchar(200)      null, -- 쿠폰 내용
    issuance_type   varchar(1)      not null, -- 지급유형 (A 자동 지급)
    issuance_condition_type   varchar(1)      not null, -- 지급 조건 구분 (A 전체발급, J 회원가입시, M 멤버쉽)
    -- 쿠폰 사용기간
    start_dt        datetime  not null,
    end_dt        datetime  not null,
    type   varchar(1)      not null, -- 쿠폰 유형 (F 정액, P 정률, G 경품-지급)
    discount_price int not null,
    max_discount_price int not null, -- 0인 경우 무제한
    limit_base_price int not null, -- 최소 기준금액 (0인 경우 제한 없음)
    allowed_issuance_type   varchar(1)      not null, -- 발급 허용 상태 (A 발급중, C 발급중지, E 발급종료)

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (쿠폰) 쿠폰-적용할 파트너 그룹
create table coupon_partner_grp
(
    seqno bigint auto_increment
        primary key,
    coupon_seqno bigint not null, 
    partner_seqno bigint not null, 

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (쿠폰) 쿠폰-사용자 발급 현황
create table coupon_user
(
    seqno bigint auto_increment
        primary key,
    coupon_seqno bigint not null, 
    user_seqno bigint not null, 

    used   varchar(1)      not null, -- 사용완료 여부 Y / N (미사용 쿠폰중 기간이 도래하면 기간만료)

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- (상품) 포인트 관리 (존재)
-- (상품) 정액권 관리 (존재)
-- (상품) 패키지 관리 (존재)

-- (멤버쉽) 멤버쉽 관리
create table product_membership
(
    seqno bigint auto_increment
        primary key,
    admin_seqno    bigint      not null,
    name   varchar(200)      not null,
    price   int      not null, -- 오프라인 가격
    limit_week   int      not null, -- 제한 주 (0 이면 무한)

    point    int      default 0, -- 부여 포인트

    deleted   varchar(1)      not null, -- 환불처리된, 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (멤버쉽) 바우처 관리
create table product_voucher
(
    seqno bigint auto_increment
        primary key,
    admin_seqno    bigint      not null,
    name   varchar(200)      not null,
    context   varchar(200)      null,
    unit_count    int      default 0, -- 발급 수량
    limit_week   int      not null, -- 제한 주 (0 이면 무한)

    use_partner   varchar(1)      not null, -- 제휴사 연결 여부 Y / N
    partner_seqno bigint null, -- 해당 제휴사
    store_seqno    bigint      null, -- 해당 매장
    product_seqno    bigint      null, -- 해당 서비스

    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- 바우처 메인
create table membership_voucher_grp
(
    seqno bigint auto_increment
        primary key,
    membership_seqno    bigint      not null,
    voucher_seqno    bigint      not null,
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- 바우처 기타 (서브 바우처)
create table membership_etc_voucher_grp
(
    seqno bigint auto_increment
        primary key,
    membership_seqno    bigint      not null,
    etc_voucher_seqno    bigint      not null,
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- 쿠폰
create table membership_coupon_grp
(
    seqno bigint auto_increment
        primary key,
    membership_seqno    bigint      not null,
    coupon_seqno    bigint      not null,
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

-- 멤버쉽 사용 내역 (쿠폰/바우처/멤버쉽 통합되어 있는데 분리해서 짜야됨)
-- product_membership_hst

-- 관리자 히스토리 (나중에)
create table admin_action_hst
(
    seqno bigint auto_increment
        primary key,
    admin_seqno    bigint      not null,
    menu_name   varchar(200)      not null, -- 메뉴
    action   varchar(10)      not null, -- action
    ip   varchar(15)      not null, -- IP
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- 컨텐츠 관리 (나중에)
-- (컨텐츠) 사용자 공지사항 (제목/내용/순서)
create table user_notice
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, 
    contents   text      not null, 
    ordered   int      not null, -- 노출순서
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 파트너 공지사항 (제목/내용/순서)
create table partner_notice
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, 
    contents   text      not null, 
    ordered   int      not null, -- 노출순서
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 자주묻는질문
create table faq
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, 
    contents   text      not null, 
    ordered   int      not null, -- 노출순서
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 도움말
create table cont_help
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, 
    contents   text      not null, 
    ordered   int      not null, -- 노출순서
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 이용약관
create table cont_usage
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, 
    contents   text      not null, 
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 개인정보처리방침
create table cont_privacy
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, 
    contents   text      not null, 
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 배너관리
create table banner
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    title   varchar(500)      not null, -- 배너명
    thumbnail   varchar(300)      not null, -- 배너 썸네일
    link   varchar(300)      not null, -- 이동할 링크
    contents   text      not null, 
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;
-- (컨텐츠) 사용자 템플릿 선택

drop table template;
create table template
(
    seqno bigint auto_increment primary key,
    admin_seqno    bigint      not null,
    file_name   varchar(200)      not null, -- 메인화면 url
    representative_img   varchar(200)      not null, -- 대표이미지 url
    choosed   varchar(1)      not null, -- 선택 여부 Y / N
    deleted   varchar(1)      not null, -- 삭제여부 Y / N
    create_dt        datetime         default CURRENT_TIMESTAMP null,
    update_dt        datetime         default CURRENT_TIMESTAMP null
) character set utf16;

insert into template (admin_seqno, file_name, representative_img, choosed, deleted) values (0, 'main2', '/adm/img/template/temp01.png', 'Y', 'N');
insert into template (admin_seqno, file_name, representative_img, choosed, deleted) values (0, 'main3', '/adm/img/template/temp02.png', 'N', 'N');
insert into template (admin_seqno, file_name, representative_img, choosed, deleted) values (0, 'main4', '/adm/img/template/temp03.png', 'N', 'N');

-- 레벨권한 설정 (나중에)
-- (쿠폰) 이벤트 쿠폰 (나중에)
