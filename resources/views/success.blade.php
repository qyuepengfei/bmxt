<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/success.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/signup-print.css')}}" media="print">
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js')}}"></script>
</head>
<body>
    <div class="main">
        <div class="top">
            <div class="inner">
                <img src="{{ asset('assets/img/logo1.png')}}" alt="">
            </div>
        </div>
        <div class="mid">
            <div class="successAlert" id="successAlert">
                <span>您已报名成功!</span>
            </div>

            <div class="title_top">
                <ul>
                    <li>RoboCom（睿抗）三航（航天航空航海）机器人挑战赛</li>
                </ul>
                <div class="clearfix clear"></div>
            </div>
            <div class="all_info clearfix clear">
                <div class="active team_info div_tab">
                    <div class="leader" id="team">
                        <span class="leader_title">队伍信息</span>
                        <div class="cut"></div>
                        <span class="name">队伍编号 :</span>
                        <span id="preview_team_id" class="name_input">{{$signdata['team_no'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name">队伍名称 :</span>
                        <span id="preview_team_name" class="name_input">{{$signdata['team_name'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name">学校/单位名称 :</span>
                        <span id="preview_school_name" class="name_input">{{$signdata['school_name'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name">学校/单位地址 :</span>
                        <span id="preview_school_address" class="name_input">{{$signdata['school_address'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name">赛事项目 :</span>
                        <span id="preview_competition_name" class="name_input">{{$signdata['competition_name'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name"></span>
                        <span id="preview_competition_type" class="name_input">{{$signdata['competition_type'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name">组别 :</span>
                        <span id="preview_competiton_group" class="name_input">{{$signdata['competition_group'] or ''}}</span>
                        <div class="clearfix clear"></div>
                    </div>
                    <div class="leader" id="leader">
                        <span class="leader_title">领队信息</span>
                        <div class="cut"></div>
                        <span class="name">领队姓名 :</span>
                        <span  id="preview_leader_name" class="name_input" >{{$signdata['leader_name'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name">身份证号 :</span>
                        <span  id="preview_leader_id" class="name_input">{{$signdata['leader_id'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name">邮箱 :</span>
                        <span  id="preview_leader_email" class="name_input">{{$signdata['leader_email'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span  class="name">手机号 :</span>
                        <span id="preview_leader_mobile" class="name_input">{{$signdata['leader_mobile'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span  class="name">性别 :</span>
                        <span id="preview_leader_sex" class="name_input">{{$signdata['leader_sex'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <img id="preview_leader_pic" src="{{$signdata['leader_pic']}}" >
                        <div class="leader_list">
                            @if($signdata['leaders'])
                            @foreach($signdata['leaders'] as $leader)
                            <div class="leader_info">
                                <div class="cut">
                                    <img id="preview_leader_pic" src="{{$leader['pic']}}" >
                                </div>
                                <span class="name">领队姓名 :</span>
                                <span  class="name_input">{{$leader['name'] or ''}}</span>
                                <div class="clearfix clear"></div>
                                <span class="name">身份证 :</span>
                                <span class="name_input">{{$leader['ID'] or ''}}</span>
                                <div class="clearfix clear"></div>
                                <span class="name">邮箱 :</span>
                                <span  class="name_input">{{$leader['email'] or ''}}</span>
                                <div class="clearfix clear"></div>
                                <span class="name">手机号 :</span>
                                <span class="name_input">{{$leader['mobile'] or ''}}</span>
                                <div class="clearfix clear"></div>
                                <span class="name">性别 :</span>
                                <span  class="name_input">{{$leader['sex'] or ''}}</span>
                                <div class="clearfix clear"></div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="all_number">
                        <span class="leader_title">队员信息</span>
                        <div class="team_number" id="number">
                            @if($signdata['members'])
                            @foreach($signdata['members'] as $member)
                            <div class="member_info">
                                <div class="cut">
                                    <img id="preview_leader_pic" src="{{$member['pic']}}" >
                                </div>
                                <span class="name">队员姓名 :</span>
                                <span  class="name_input">{{$member['name'] or ''}}</span>
                                <div class="clearfix clear"></div>
                                <span class="name">证件类型 :</span>
                                <span  class="name_input">{{$member['id_type'] or '身份证'}}</span>
                                <div class="clearfix clear"></div>
                                <span class="name">证件号码 :</span>
                                <span class="name_input">{{$member['ID'] or ''}}</span>
                                <div class="clearfix clear"></div>
                                <span class="name">手机号 :</span>
                                <span class="name_input">{{$member['mobile'] or ''}}</span>
                                <div class="clearfix clear"></div>
                                <span class="name">性别 :</span>
                                <span  class="name_input">{{$member['sex'] or ''}}</span>
                                <div class="clearfix clear"></div>
                                <span class="name">年龄 :</span>
                                <span  class="name_input">{{$member['age'] or ''}}</span>
                                <div class="clearfix clear"></div>
                                <span class="name">身高(单位cm) :</span>
                                <span  class="name_input">{{$member['height'] or ''}}</span>
                                <div class="clearfix clear"></div>
                                <span class="name" >学校/单位名称 :</span>
                                <span class="name_input">{{$member['school_name'] or ''}}</span>
                                <div class="clearfix clear"></div>
                                <span class="name" style="margin-bottom: 30px;">学校/单位地址 :</span>
                                <span class="name_input">{{$member['school_address'] or ''}}</span>
                                <div class="clearfix clear"></div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="pays clearfix" id="pays">
                        <span class="leader_title">开票信息</span>
                        <div class="cut"></div>
                        <span class="name">参赛总人数 :</span>
                        <span id="preview_participant" class="name_input">{{$signdata['participant'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name">金额(每人) :</span>
                        <span id="preview_average_amount" class="name_input">{{$signdata['average_amount'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name">总费用 :</span>
                        <span id="preview_total_cost" class="name_input">{{$signdata['total_cost'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name">账户类型 :</span>
                        <span id="preview_account_type" class="name_input">{{$signdata['account_type'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name">发票抬头 :</span>
                        <span id="preview_invoice_header" class="name_input">{{$signdata['invoice_header'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name">开票内容 :</span>
                        <span id="preview_billing_content" class="name_input">{{$signdata['billing_content'] or ''}}</span>
                        <div class="clearfix clear"></div>
                        <span class="name">收件地址 :</span>
                        <span id="preview_receive_address" class="name_input">{{$signdata['receive_address'] or ''}}</span>
                        <div class="clearfix clear"></div>
                    </div>

                    <div class="clearfix clear">
                    </div>
                </div>
            </div>
            </form>
        </div>

        <input class="button-print" type="button" value="打印" onclick="window.print()">
        <div class="bot">
            <div class="inner">
                <div class="logo-all">
                    <img src="{{ asset('assets/img/LOGO2.png')}}" alt="">
                    <img src="{{ asset('assets/img/logo-white-word.png')}}" alt="">
                </div>
                <span class="sp1">© 2017 RoboCom 国际公开赛组委会  |  鄂ICP备16011249号-2 </span>
                <span class="sp2">技术支持: 北京啃萝卜信息技术有限公司</span>
            </div>
        </div>
    </div>
<script type="text/javascript">
    setTimeout(function(){
        $('#successAlert').css({
            'opacity': 0,
            'margin-bottom': '0px'
        });
    }, 3000);

    var game_name = ["RoboCom星际迷航", "'一带一路'智能挑战", "RoboCom星球大战", "创客生存挑战", "水中机器人协同竞技"]; //直接声明Array
    var game_type = [
        ["RoboCom星际迷航"],
        ["'一带一路'智能挑战"],
        ["RoboCom星球大战"],
        ["创客生存挑战"],
        ["水中机器人协同竞技"]
    ];
    var get_competition_type = $('#preview_competition_type').text();

    isIE8();
    function isIE8(){
        if (navigator.appName === 'Microsoft Internet Explorer') {
            if (navigator.userAgent.match(/Trident/i) && navigator.userAgent.match(/MSIE 8.0/i)) {
                for (x in game_type)
                {
                    if (!Array.prototype.indexOf){
                        Array.prototype.indexOf = function(elt /*, from*/){
                        var len = this.length >>> 0;
                        var from = Number(arguments[1]) || 0;
                        from = (from < 0)
                             ? Math.ceil(from)
                             : Math.floor(from);
                        if (from < 0)
                          from += len;
                        for (; from < len; from++)
                        {
                          if (from in this &&
                              this[from] === elt)
                            return from;
                        }
                        return -1;
                      };
                    }
                    if (game_type[x].indexOf(get_competition_type) > -1) {
                        $('#preview_competition_name').html(game_name[x]);
                    }
                }
            }else {
                for (x in game_type)
                {
                    if (game_type[x].indexOf(get_competition_type) > -1) {
                        $('#preview_competition_name').html(game_name[x]);
                    }
                }
            }
        }else {
            for (x in game_type)
            {
                if (game_type[x].indexOf(get_competition_type) > -1) {
                    $('#preview_competition_name').html(game_name[x]);
                }
            }
        }
    }

</script>
</body>
</html>
