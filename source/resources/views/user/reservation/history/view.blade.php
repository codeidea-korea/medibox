
@include('user.header2')

    <section id="res_detail" class="check">
        <div class="history_wrap">
            <div class="mid">
                <div class="date">
                    <h3>예약 날짜</h3>
                    <ul>
                        <li class="cancelDt">2022년 2월 15일 (수) 14:30</li>
                    </ul>
                </div>
                <div class="store">
                    <h3>예약 매장</h3>
                    <ul>
                        <li class="cancelShop">미니쉬스파</li>
                    </ul>
                </div>
                <div class="menu">
                    <h3>예약 메뉴</h3>
                    <ul>
                        <li class="cancelService">구강 종합 검진</li>
                    </ul>
                </div>
                <div class="price">
                    <h3>예약 예상 금액</h3>
                    <span class="cancelPrice">480,000원</span>
                </div>
                <div class="bot">
                    <a href="#" class="share_btn">
                        <img src="/user/img/icon_share.svg" alt="공유하기">
                    </a>
                    <a href="#" onclick="gotoModify()" class="change_btn">예약변경</a>
                    <a href="#" onclick="openRemove()" class="cancle_btn">예약취소</a>
                </div>
            </div>
        </div>
        <div class="info_wrap">
            <div>
                <div class="alarm_wrap">
                    <div class="button">
                        <h2>예약 알림 설정</h2>
                        <button type="button" id="alarm" onclick="wait()">
                            <span class="handler"></span>
                        </button>
                    </div>
                    <div class="time_wrap">
                        <ul>
                            <li><a href="#!">24시간</a></li>
                            <li><a href="#!">6시간</a></li>
                            <li><a href="#!">3시간</a></li>
                            <li><a href="#!">1시간</a></li>
                        </ul>
                    </div>
                    <p>예약 날짜 전 알림을 받을 시간대를 선택해주세요.</p>
                </div>
            </div>
            <div>
                <div class="res_user">
                    <h2>예약자 정보</h2>
                    <div class="name">
                        <h3>이름</h3>
                        <span>미니쉬</span>
                    </div>
                    <div class="num">
                        <h3>연락처</h3>
                        <span>010-1234-5678</span>
                    </div>
                </div>
            </div>
            <div class="privacy_policy_wrap">
                <h2>개인정보 수집·이용</h2>
                <div class="select_wrap">
                    <div class="select_box">
                        <span>개인정보 수집·이용</span>
                        <img src="/user/img/arrow_bottom.svg" alt="">
                    </div>
                    <div class="policy">
                        <ul class="txt_wrap">
                            <li>
                                미니쉬테크놀로지 주식회사(이하 “미니쉬테크”)가 운영하는 미니쉬라운지(이하 “라운지”)는 「개인정보보호법」 제30조에 따라 정보주체의 개인정보를 보호하고 이와 관련한 고충을 신속하고 원활하게 처리할 수 있도록 하기 위하여 다음과 같이 개인정보처리방침을 수립•공개합니다.
                                본 개인정보처리방침은 법률의 제•개정, 정부의 정책 변경, 회사의 내부 방침의 변경에 따라 변경될 수 있으며, 수시로 확인하여 주시기 바랍니다.    
                            </li>
                            <li>
                                본 개인정보처리방침은 다음과 같은 내용을 담고 있습니다.<br>
                                제1조 개인정보의 수집 범위<br>
                                제2조 개인정보의 수집 및 이용목적
                                제3조 개인정보의 처리기간<br>
                                제4조 개인정보의 제3자 제공<br>
                                제5조 개인정보처리업무의 위탁<br>
                                제6조 정보주체와 법정대리인의 권리•의무 및 행사방법<br>
                                제7조 개인정보의 파기<br>
                                제8조 개인정보의 안정성 확보 조치<br>
                                제9조 쿠키의 운용 및 활용<br>
                                제10조 개인정보 보호책임자<br>
                                제11조 권익침해 구제방법<br>
                                제12조 개인정보 처리방침의 변경
                            </li>
                            <li>
                                <h3>제1조 (개인정보의 수집 범위)</h3>
                                라운지는 적법하고 공정한 수단에 의하여 서비스 제공을 위하여 필요한 최소한의 범위 내에서 개인정보를 수집하고 있습니다.
                                수집하는 개인정보는 기본적 인권을 침해할 우려가 있는 민감한 개인정보(인종, 종교, 사상, 출신지, 본적지, 정치적 성향 및 범죄기록, 건강상태 및 성생활 등)는 기본적으로 수집하지 않습니다. 단, 특정 프로그램 이용 시 민감정보 중 일부 수집하며 그 경우 별도 안내를 통해 동의를 구합니다.                    
                            </li>
                            <li>
                                <h3>제2조 (개인정보의 수집 및 이용목적)</h3>
                                라운지는 다음과 같은 목적을 위해 개인정보를 처리하고 있습니다. 처리하고 있는 개인정보는 다음의 목적 이외의 용도로는 수집∙이용하지 않으며, 그 목적이 변경되거나 원래 목적 이외의 목적으로 활용될 경우에는 개인정보보호법 제18조에 따라 별도의 정보주체의 동의를 받는 등 필요한 조치를 이행할 예정입니다.                    
                            </li>
                            <li>
                                「개인정보보호법」 제24조 2항에 따라 2014년 8월 7일부터 ‘주민등록번호’의 처리가 제한되고 있으나 법령에서 구체적으로 주민등록번호의 처리를 요구하거나 허용하는 경우에는 예외적 처리가 가능하며, 이에 따라 당사는 관광진흥법 시행규칙 제28조에서 규정하고 있는 회원증의 발급을 위해 회원의 주민등록번호를 수집∙이용 및 제3자 제공이 가능함을 알려드립니다.
                                <ul class="depth">
                                    <li>- 정보 수집•이용•제공 동의는 거부할 수 있으나 필수적 정보 및 고유식별정보에 대한 동의가 없을 경우 거래관계의 설정 또는 유지가 불가능 할 수 있음을 알려드립니다.</li><br>
                                    <li>- 선택적 정보의 처리에 관한 동의는 거부하실 수 있으나, 동의하지 않는 경우 일부 서비스 및 편의제공 등에 제한이 있을 수 있음을 알려드립니다.</li>
                                </ul>
                            </li>
                            <li>
                                <h3>제3조 (개인정보의 처리 기간)</h3>
                                1.	라운지는 이용자 또는 멤버십 회원의 개인정보 삭제 요청 시에는 수집된 개인정보가 열람 또는 이용될 수 없도록 즉시 처리합니다.<br>
                                2.	하지만, 해지 시 상법 등 법령의 규정에 의하여 더 보존할 필요성이 있는 경우에는 법령에서 규정한 보존기간 동안 거래내역과 최소한의 기본정보를 보유할 수 있으며 보유기간을 미리 고지하거나 개별적으로 동의를 받은 경우에는 약속한 보존기간 동안 개인정보를 보유합니다. 이 경우, 라운지는 보유하는 정보를 그 보유 목적으로만 이용하며, 보존기간은 아래와 같습니다.
                                <ul class="depth">
                                    <li>가.	계약 또는 청약철회 등에 관한 기록 5년</li>
                                    <li>나.	대금결제 및 재화 등의 공급에 관한 기록 5년</li>
                                    <li>다.	소비자의 불만 또는 분쟁처리에 관한 기록 3년</li>
                                </ul>
                            </li>
                            <li>
                                <h3>제4조 (개인정보의 제3자 제공)</h3>
                                1.	라운지는 정보주체의 동의가 있거나 관련 법령의 규정에 의한 경우를 제외하고는 어떠한 경우에도 “제2조 개인정보의 수집 및 이용목적”에서 고지한 범위를 넘어 개인정보를 이용하거나 타인 또는 타기업/기관에 제공 하지 않습니다.<br>
                                2.	라운지가정보주체의 사전동의 없이 개인정보를 제 3자에게 제공할 수 있는 경우는 다음과 같습니다.
                                <ul class="depth">
                                    <li>가.	정보주체의 사전 동의를 얻은 경우</li>
                                    <li>나.	통신비밀보호법, 정보통신망 이용촉진 및 정보보호에 관한 법률, 금융실명거래 및 비밀보장에 관한 법률, 신용정보의 이용 및 보호에 관한 법률, 전기통신기본법, 전기통신사업법, 소비자보호법, 형사소송법 등 법률에 특별한 규정이 있는 경우 및 수사 목적으로 법령에 정해진 절차와 방법에 따라 수사기관의 요구가 있는 경우</li>
                                    <li>다.	통계작성, 학술연구 또는 시장조사를 위하여 필요한 경우 특정 개인을 알아볼 수 없는 형태로 가공하여 제공하는 경우</li>
                                </ul>
                                3.	한편 보다 더 질 높은 서비스 제공을 위하여 정보주체의 개인정보를 제휴사에 제공하거나 또는 제휴사와 공유할 수 있습니다. 개인정보를 제공하거나 공유할 경우 개인정보를 제공 받는 자, 이용목적, 개인정보 제공 항목, 보유 및 이용기간에 대해 개별적으로 전자우편, 인터넷 홈페이지, 전화 및 서면을 통해 동의를 구하는 절차를 거치게 되며, 정보주체의 동의가 없을 경우에는 제휴사에 제공하거나 제휴사와 공유하지 않습니다. 라운지의개인정보 제공은 라운지만의 서비스를 제공하기 위한 것이므로 제공에 대한 동의를 하지 아니하면 정상적인 서비스 제공 및 이용이 불가능 할 수 있습니다.
                            </li>
                            <li>
                                <h3>제5조 (개인정보처리업무의 위탁)</h3>
                                라운지는 서비스 이행을 위해 아래와 같이 개인정보를 위탁하고 있으며, 관계법령에 따라 위탁계약서에 개인정보가 안전하게 관리 될 수 있도록 필요한 사항을 규정하고 있습니다. 위탁을 받은 업체는 위탁을 받은 목적을 벗어나서 개인정보를 이용할 수 없습니다. 또한 라운지는 이러한 위탁업체에 대하여 해당 개인정보가 위법하게 이용되지 않도록 정기적인 감시와 감독을 실시하고, 업무의 일부를 위탁하는 경우 정보주체에게 미리 그 사실을 고지합니다. 개인정보 위탁업체는 다음과 같습니다.
                                <table>
                                    <tr>
                                        <td>수탁사</td>
                                        <td>위탁업무 내용</td>
                                    </tr>
                                    <tr>
                                        <td>발몽스파</td>
                                        <td>스파제공</td>
                                    </tr>
                                    <tr>
                                        <td>딥포커스</td>
                                        <td>검안제공</td>
                                    </tr>
                                    <tr>
                                        <td>바라는네일</td>
                                        <td>네일제공</td>
                                    </tr>
                                </table>
                            </li>
                            <li>
                                <h3>제6조 (정보주체와 법정대리인의 권리•의무 및 행사방법)</h3>
                                1.	정보주체는라운지에 대해 언제든지 다음 각 호의 개인정보보호 관련 권리를 행사할 수 있습니다.
                                <ul class="depth">
                                    <li>가.	개인정보 열람요구</li>
                                    <li>나.	변경 및 오류 등이 있을 경우 정정요구</li>
                                    <li>다.	삭제요구</li>
                                    <li>라.	처리정지 요구</li>
                                </ul>
                                2.	제1항에 따른 권리 행사는 라운지에 대해 「개인정보보호법 시행규칙」 별지 제8호, 제10호 서식에 따라 서면, 전자우편, 모사전송(FAX) 등을 통하여 하실 수 있으며 라운지는 이에 대해 지체 없이 조치해 드릴 것입니다. 정보주체가 개인정보의 오류 등에 대한 정정 또는 삭제를 요구한 경우에는 라운지는 정정 또는 삭제를 완료할 때까지 해당 개인정보를 이용하거나 제공하지 않습니다.<br>
                                3.	제1항에 따른 권리 행사는 정보주체의 법정대리인이나 위임을 받은 자 등 대리인을 통하여 하실 수 있습니다. 이 경우 「개인정보보호법 시행규칙」 별지 제11호 서식에 따른 위임장을 제출하셔야 합니다.<br>
                                4.	개인정보 열람 및 처리정지 요구는 「개인정보보호법」 제35조 제5항, 제37조 제2항에 의하여 정보주체의 권리가 제한될 수 있습니다.<br>
                                5.	개인정보의 정정 및 삭제 요구는 다른 법령에서 그 개인정보가 수집 대상으로 명시되어 있는 경우에는 그 삭제를 요구할 수 없습니다.<br>
                                6.	라운지는 정보주체 권리에 따른 열람의 요구, 정정•삭제의 요구, 처리정지의 요구 시 열람 등 요구를 한 자가 본인이거나 정당한 대리인이지를 확인합니다.
                            </li>
                            <li>
                                <h3>제7조 (개인정보의 파기)</h3>
                                1.	라운지는 개인정보 보유기간의 경과, 처리목적 달성 등 개인정보가 불필요하게 되었을 때에는 지체없이 해당 개인정보를 파기합니다.<br>
                                2.	정보주체로부터 동의 받은 개인정보 보유기간이 경과하거나 처리목적이 달성되었음에도 불구하고 다른 법령에 따라 개인정보를 계속 보존하여야 하는 경우, 회사는 해당 개인정보를 별도의 데이터베이스(DB)로 옮기거나 보관장소를 달리하여 보존합니다.<br>
                                3.	개인정보 파기의 절차 및 방법은 다음과 같습니다.
                                <ul class="depth">
                                    <li>가.	파기절차: 라운지는 파기 사유가 발생한 개인정보를 선정하고, 개인정보 보호책임자의 승인을 받아 개인정보를 파기합니다.</li>
                                    <li>나.	파기방법: 종이에 출력된 개인정보는 분쇄하거나 소각하여 파기하고, 전자적 파일 형태로 기록•저장된 개인정보는 복원할 수 없는 기술적 방법을 사용하여 영구 삭제합니다.</li>
                                </ul>                    
                            </li>
                            <li>
                                <h3>제8조 (개인정보의 안정성 확보 조치)</h3>
                                <p>라운지는 「개인정보보호법」 제 29조에 따라 다음과 같이 안전성 확보에 필요한 기술적/관리적 및 물리적 조치를 취하고 있습니다.</p>
                                
                                1.	관리적 조치
                                <ul class="depth">
                                    <li>가.	개인정보보호를 위해 개인정보 처리자에 대한 권한 부여를 최소화하고 있습니다.</li>
                                    <li>나.	개인정보보호에 대한 인식 제고를 위해 정기적인 교육을 시행하고 있습니다.</li>
                                    <li>다.	개인정보의 처리 관련 안정성 확보를 위해 정기적으로 자체 점검을 실시하고 있습니다.</li>
                                </ul>
                                2.	기술적 조치
                                <ul class="depth">
                                    <li>가.	개인정보의 안전한 처리 및 관리를 위해 내부관리계획을 수립하여 관리하고 있습니다.</li>
                                    <li>나.	정보주체의 개인정보와 비밀번호는 암호화되어 저장•관리되고 있으며 전송 시에도 별도의 보안기능을 사용하여 안전하게 관리하고 있습니다.</li>
                                    <li>다.	해킹이나 컴퓨터 바이러스 등에 의한 개인정보 유출 및 훼손을 막기 위하여 보안 프로그램을 설치하고 주기적인 갱신•점검을 하여 외부로부터 접근이 통제된 구역에 시스템을 설치하고 기술적, 물리적으로 감시 및 차단하고 있습니다.</li>
                                    <li>라.	개인정보를 처리하는 데이터베이스시스템에 대한 접근권한의 부여, 변경, 말소를 통하여 개인정보에 대한 접근통제를 위하여 필요한 조치를 하고 있으며 침입차단 시스템을 이용하여 외부로부터의 무단 접근을 통제하고 있습니다.</li>
                                </ul>
                                3.	물리적 조치
                                <ul class="depth">
                                    <li>가.	개인정보가 포함된 서류, 보조저장매체 등을 잠금장치가 있는 안전한 장소에 보관하고 있습니다.</li>
                                    <li>나.	개인정보를 보관하고 있는 물리적 보관 장소를 별도로 두고 이에 대해 출입통제 절차를 수립, 운영하고 있습니다.</li>
                                    <li>다.	천재지변을 비롯한 재해, 재난 발생에 대비하여 위기대응 매뉴얼 등 대응절차를 마련하고 점검하고 있습니다.</li>
                                </ul>
                            </li>
                            <li>
                                <h3>제9조 (쿠키의 운용 및 활용)</h3>
                                1.	쿠키(cookie) 운용
                                라운지는 이용자의 편의를 위하여 ‘쿠키’를 운영하며, 쿠키를 통해 수집된 정보는 접속 빈도, 방문 시간 등을 분석하여 맞춤화된 마케팅 서비스에 이용합니다.<br>
                                2.	쿠키(cookie)의 설치•운영 및 거부
                                고객은 쿠키 설치에 대한 선택권을 가지고 있으며, 웹브라우져에서 옵션을 설정하여 모
                                든 쿠키를 허용하거나, 쿠키가 저장될 때마다 확인을 거치게 하거나 아니면 쿠키의 저장
                                을 거부할 수 있습니다. 단, 쿠키저장을 거부하였을 경우 로그인이 필요한 서비스에 일부 
                                제한이 있을 수 있습니다.                    
                            </li>
                            <li>
                                <h3>제10조 (개인정보 보호책임자)</h3>
                                <p>라운지는 개인정보 처리에 관한 업무를 총괄해서 책임지고, 개인정보 처리와 관련한 정보주체의 불만처리 및 피해구제 등을 위하여 아래와 같이 개인정보 보호책임자 및 담당자를 지정하고 있습니다. 개인정보와 관련된 문의사항이 있으시면 아래의 개인정보 보호책임자 또는 보호담당자에게 연락 주시기 바랍니다. 문의하신 사항에 대해서 신속하고 성실하게 답변해 드리겠습니다.</p><br>
                                개인정보 보호책임자
                                <table>
                                    <tr>
                                        <td>성명</td>
                                        <td>소속</td>
                                        <td>직책/직위</td>
                                        <td>연락처</td>
                                        <td>이메일</td>
                                    </tr>
                                    <tr>
                                        <td>박희진</td>
                                        <td>기획팀</td>
                                        <td>대리</td>
                                        <td>010-3575-5054</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>문성모</td>
                                        <td>개발팀</td>
                                        <td>팀장</td>
                                        <td>010-2974-0017</td>
                                        <td></td>
                                    </tr>
                                </table>                    
                            </li>
                            <li>
                                <h3>제11조 (권익침해 구제방법)</h3>
                                <p>정보주체는 아래의 기관을 통하여 개인정보 침해에 대한 피해구제, 상담 등을 하실 수 있음을 알려드립니다.</p><br>
                                1.	개인정보 침해신고센터 (한국인터넷진흥원 운영)
                                <ul class="depth">
                                    <li>-	소관업무: 개인정보 침해사실 신고, 상담 신청</li>
                                    <li>-	홈페이지: privacy.kisa.or.kr</li>
                                    <li>-	전화: (국번없이) 118</li>
                                    <li>-	주소: (58324) 전남 나주시 진흥길 9(빛가람동 301-2) 3층 개인정보침해신고센터</li>
                                </ul>
                                2.	개인정보 분쟁조정위원회
                                <ul class="depth">
                                    <li>-	소관업무: 개인정보 분쟁조정신청, 집단분쟁조정 (민사적 해결)</li>
                                    <li>-	홈페이지: www.kopico.go.kr</li>
                                    <li>-	전화: (국번없이) 1833-6972</li>
                                    <li>-	주소: (03171)서울특별시 종로구 세종대로 209 정부서울청사 4층</li>
                                </ul>
                                3.	대검찰청 사이버범죄수사단
                                <ul class="depth">
                                    <li>-	전화: 02-3480-3573</li>
                                    <li>-	홈페이지: www.spo.go.kr</li>
                                    <li>-	경찰청 사이버안전국</li>
                                    <li>-	전화: (국번없이) 182</li>
                                    <li>-	홈페이지: http://cyberbureau.police.go.kr</li>
                                </ul>                
                            </li>
                            <li>
                                <h3>제12조 (개인정보 처리방침의 변경)</h3>
                                <p>법률의 제ㆍ개정, 정부의 정책 변경, 회사 내부방침의 변경 또는 보안기술의 변경에 따라 내용의 추가, 삭제 및 수정이 있을 시에는 지체없이 홈페이지를 통해 변경내용 등을 공지하도록 하겠습니다. 본 개인정보처리방침의 내용은 수시로 변경될 수 있으므로 "홈페이지"를 방문하실 때마다, 이를 확인하시기 바랍니다.</p>
                                본 개인정보처리방침은 2022년 03월 18일부터 적용합니다.
                            </li>
                        </ul>
                    </div>
                </div>
                <p class="des">예약 서비스 이용을 위한 개인정보 수집 및 제3자 제공, 취소/환불 규정을 확인하였으며 이에 동의합니다.</p>
            </div>            
        </div>
    </section>


    <div class="modal_wrap share">
        <div class="modal_inner">
            <h4>링크 공유</h4>
            <ul>
                <li><a href="#">
                    <img src="/user/img/icon_copy.svg" alt="링크 복사">
                    <span>링크 복사</span>
                </a></li>
                <li><a href="#">
                    <img src="/user/img/kakao.svg" alt="카카오톡 공유하기">
                    <span>카카오톡</span>
                </a></li>
                <li><a href="#">
                    <img src="/user/img/naver.svg" alt="네이버 공유하기">
                    <span>네이버</span>
                </a></li>
                <li><a href="#">
                    <img src="/user/img/google.svg" alt="구글 공유하기">
                    <span>구글</span>
                </a></li>
            </ul>
            <a href="#" class="close_btn">취소</a>
        </div>
    </div>


    <div id="popup22" class="popup select reservation">
        <div class="container">
            <div class="history_wrap">
                <div class="mid">
                    <h2>예약취소</h2>
                    <div class="date">
                        <h3>예약 날짜</h3>
                        <ul>
                            <li class="cancelDt">2022년 3월 19일 (토) 16:00</li>
                        </ul>
                    </div>
                    <div class="store">
                        <h3>예약 매장</h3>
                        <ul>
                            <li class="cancelShop">포레스타 블랙</li>
                        </ul>
                    </div>
                    <div class="menu">
                        <h3>예약 메뉴</h3>
                        <ul>
                            <li class="cancelService">포레스타 펌</li>
                            <li class="cancelDesigner">[디자이너] 릴리</li>
                        </ul>
                    </div>
                    <!-- 22.03.14 추가 -->
                    <p>예약을 정말로 취소하시겠습니까?</p>
                </div>
            </div>
            <div class="bottom">
                <a href="#" class="close_btn">아니오</a>
                <a href="#" onclick="remove()">네</a>
            </div>
        </div>
    </div> 
    <!----------------->


    <!-- 22.03.14 추가 -->
    <div id="popup23" class="popup select reservation">
        <div class="container">
            <div class="history_wrap">
                <div class="mid">
                    <h2>예약취소완료</h2>
                    <div class="date">
                        <h3>예약 날짜</h3>
                        <ul>
                            <li class="cancelDt">2022년 3월 19일 (토) 16:00</li>
                        </ul>
                    </div>
                    <div class="store">
                        <h3>예약 매장</h3>
                        <ul>
                            <li class="cancelShop">포레스타 블랙</li>
                        </ul>
                    </div>
                    <div class="menu">
                        <h3>예약 메뉴</h3>
                        <ul>
                            <li class="cancelService">포레스타 펌</li>
                            <li class="cancelDesigner">[디자이너] 릴리</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <a href="#" onclick="location.reload()">확인</a>
            </div>
        </div>
    </div>

    <script>
    // list get
    let price = 0;
    function toReservationDate(aaa){
        return aaa;
    }
    function loadHistory(){
        var data = { user_seqno:{{ $seqno }}, id: {{$historyNo}} };

		medibox.methods.store.reservation.one(data, {{$historyNo}}, function(request, response){
			console.log('output : ' + response);
			if(!response.result){
				alert(response.ment);
				return false;
            }
            price = response.data.serviceInfo.price;
            $('.cancelPrice').text(medibox.methods.toNumber(response.data.serviceInfo.price)+'원');
            $('.cancelDt').text(toReservationDate(response.data.start_dt));
            $('.cancelShop').text(response.data.storeInfo.name);
            $('.cancelService').text((response.data.serviceInfo ? response.data.serviceInfo.name : '-'));
            $('.cancelDesigner').text('['+(response.data.managerInfo ? response.data.managerInfo.manager_type : '기본')+'] '
                                                    +(response.data.managerInfo ? response.data.managerInfo.name : '-'));
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
    }
    function openRemove(){
        $('#popup22').addClass('on');
    }
    
	function remove(){
        // 예약금 환불후 취소 처리
        var point_type = 'P';
		var memo = '사용자 예약 환불';
		
		var data = { admin_seqno:1, user_seqno:{{ $seqno }}, product_seqno: 0,
            point_type:point_type, memo:memo, amount: price, admin_name: '' };
            
		medibox.methods.point.refund(data, function(request, response){
			console.log('output : ' + response);
            if(!response.result){
                alert(response.ment);
                return false;
            }
            medibox.methods.store.reservation.status({
                status: 'C'
            }, {{$historyNo}}, function(request, response){
                console.log('output : ' + response);
                if(!response.result){
                    alert(response.ment);
                    return false;
                }
                $('#popup23').addClass('on');
            }, function(e){
                console.log(e);
                alert('서버 통신 에러');
            });
		}, function(e){
			console.log(e);
			alert('서버 통신 에러');
		});
	}
    function gotoModify(){
        location.href = '/reservation/history/{{$historyNo}}/modify';
    }

    $(document).ready(function(){
        loadHistory();
    });
    </script>

    @include('user.footer')

</body>