<?php
namespace App\Enroll;

use App\Enroll\Models\Competition;
use App\Enroll\Models\CompetitionEvent;
use App\Enroll\Models\CompetitionTeam;
use App\Enroll\Models\CompetitionTeamMember;
use Excel;

/*
 * 邀请码管理
 */
class CompetitionService
{

	protected $competitionList = null;

	public function initEvents()
	{
		$origin_data = $this->getOriginData();
		$this->initEventsRecursive($origin_data);
	}

	private function getOriginData()
	{
		$origin_data = [
            'RoboCom星际迷航' => [
                'RoboCom星际迷航' => [
                    "小学" => 1,
                    "初中" => 1,
                    "高中（含中职）" => 1,
                ],
            ],
            "'一带一路'智能挑战" => [
                "'一带一路'智能挑战" => [
                    "小学" => 1,
                    "初中" => 1,
                    "高中（含中职）" => 1,
                ],
            ],
            'RoboCom星球大战' => [
                'RoboCom星球大战' => [
                    "小学" => 1,
                    "初中" => 1,
                    "高中（含中职）" => 1,
                ],
            ],
			'创客生存挑战' => [
			    '创客生存挑战' => [
			        "小学" => 1,
			        "初中" => 1,
			        "高中（含中职）" => 1,
			    ],
			],
			'水中机器人协同竞技' => [
			    '水中机器人协同竞技' => [
			        "小学" => 1,
			        "初中" => 1,
			        "高中（含中职）" => 1,
			    ],
			],
		];

		return $origin_data;
	}

	private function initEventsRecursive($data, $parent_id = 0)
	{
		if (!is_array($data)) {
			return;
		}

		foreach ($data as $name => $val) {
			$id = $this->addEvents($name, $parent_id);
			$this->initEventsRecursive($val, $id);
		}
	}

	private function addEvents($name, $parent_id = 0)
	{
		$event = CompetitionEvent::create([
			'name' => $name,
			'parent_id' => $parent_id,
		]);

		return $event->id;
	}

	public function getCompetitionList()
	{
		// 计算出第一层数据
		$result = $this->findChidren(0);

		foreach ($result as $id => $value) {
			$result[$id]['children'] = $this->findChidren($id);
		}

		foreach ($result as $id1 => $val_level1) {
			foreach ($val_level1['children'] as $id2 => $val_level2) {
				$result[$id1]['children'][$id2]['children'] = $this->findChidren($id2);
			}
		}

		return $result;
	}

	public function findChidren($parent_id)
	{
		if ($this->competitionList == null) {
			$this->competitionList = CompetitionEvent::all();
		}

		$children = [];
		foreach ($this->competitionList as $k => $val) {
			if ($val['parent_id'] == $parent_id) {
				$children[$val['id']] = [
					'id' => $val['id'],
					'name' => $val['name']
				];
			}
		}

		return $children;
	}

    public function searchTeam($team_no, $contact_mobile)
    {
        $teamData = CompetitionTeam::where('team_no', $team_no)
                                    ->where('contact_mobile', $contact_mobile)
                                    ->with('members')->first();

        if ($teamData === null) {
            return null;
        }

        // 比赛项目
        $teamEvent = $teamData->event;
        $eventItems = collect([]);
        while ($teamEvent != null) {
            $eventItems->push([
                'id' => $teamEvent->id,
                'name'   => $teamEvent->name,
                'parent_id' => $teamEvent->parent_id,
                ]);
            $teamEvent = $teamEvent->parent;
        }

        $eventItems = $eventItems->reverse();
        $teamData = $teamData->toArray();
        $teamData['eventItems'] = $eventItems->toArray();
        $teamData['competition_1'] = $eventItems[0]['name'];
        $teamData['competition_2'] = $eventItems[1]['name'];
        $teamData['competition_3'] = $eventItems[2]['name'];
        $eventItemsKeys = $eventItems->pluck('id');
        $teamData['eventItemsKeys'] = $eventItemsKeys;

        return $teamData;
    }
    public function getTeamList($enroll_user_id)
    {
        return CompetitionTeam::where('enroll_user_id', $enroll_user_id)->get();
    }

    public function getTeamData($team_no)
    {
        $teamData = CompetitionTeam::where('team_no', $team_no)
                                    ->with('members')->first();

        if ($teamData === null) {
            return null;
        }

        // 比赛项目
        $teamEvent = $teamData->event;
        $eventItems = collect([]);
        while ($teamEvent != null) {
            $eventItems->push([
                'id' => $teamEvent->id,
                'name'   => $teamEvent->name,
                'parent_id' => $teamEvent->parent_id,
                ]);
            $teamEvent = $teamEvent->parent;
        }

        $eventItems = $eventItems->reverse();
        $teamData = $teamData->toArray();
        $teamData['eventItems'] = $eventItems->toArray();
        $teamData['competition_1'] = $eventItems[0]['name'];
        $teamData['competition_2'] = $eventItems[1]['name'];
        $teamData['competition_3'] = $eventItems[2]['name'];
        $eventItemsKeys = $eventItems->pluck('id');
        $teamData['eventItemsKeys'] = $eventItemsKeys;

        return $teamData;
    }

    public function getTeams()
    {
    	$teamList = CompetitionTeam::with('members')->with('user')->get();
    	foreach ($teamList as $k => $team) {
    		$teamEvent = $team->event;
        	$eventItems = collect([]);
	        while ($teamEvent != null) {
	            $eventItems->push([
	                'id' => $teamEvent->id,
	                'name'   => $teamEvent->name,
	                'parent_id' => $teamEvent->parent_id,
	                ]);
	            $teamEvent = $teamEvent->parent;
	        }

	        $eventItems = $eventItems->reverse();
	        $teamList[$k]['competition_1'] = $eventItems[0]['name'];
	        $teamList[$k]['competition_2'] = $eventItems[1]['name'];
	        $teamList[$k]['competition_3'] = $eventItems[2]['name'];
    	}

    	return $teamList;
    }

    public function makeExcel($filename)
    {
    	$teamList = $this->getTeams();
        Excel::create($filename, function($excel) use($teamList) {

            $excel->setTitle('RoboCom（睿抗）三航（航天航空航海）机器人挑战赛');
            $excel->setCreator('RoboCom')
                  ->setCompany('RoboCom');
            $excel->setDescription('报名数据');

            $excel->sheet('报名数据', function($sheet) use($teamList) {
            	$sheet->setAutoSize(true);
                $sheet->mergeCells('A1:C1');
                $sheet->mergeCells('D1:K1');
                $sheet->mergeCells('L1:AB1');
                $sheet->mergeCells('AC1:AK1');
                $sheet->cell('A1', '用户信息');
                $sheet->cell('D1', '队伍信息');
                $sheet->cell('M1', '成员信息');
                $sheet->cell('AC1', '开票信息');
                // 居中
                $sheet->row(1, function($row) {
                    $row->setAlignment('center');
                });
                $sheet->row(2, function($row) {
                    $row->setAlignment('center');
                });

                // 11 Elements 基础部分
                $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];

                $columnKeys = ['user_name', 'user_mobile', 'user_email', 'team_no', 'team_name', 'competition_1', 'competition_3', 'remark',
                                    'contact_name', 'contact_mobile', 'contact_email', 'contact_remark'];


                $sheet->row(2, [ '用户名', '用户电话', '用户邮箱', '队伍编号', '队伍名称', '赛事项目', '组别', '队伍备注',
                				 '联系人', '联系人手机', '联系人邮箱', '联系人备注',
                				 '身份', '姓名', '性别', '年龄', '学校', '班级', '工作单位', '证件类型', '证件号码', '监护人', '关系', '联系地址', '手机号码', '邮箱', '学校校长姓名', '备注',
                                 '是否需要开票', '开票抬头', '同意社会信用代码', '开票金额', '开票明细', '收件地址', '联系人姓名', 'E-mail', '备注', '']);

                $rowIndex = 3;

                // 9 Elements 开票部分
                $invoice = ['AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK'];
                $invoiceKeys = ['invoice_type', 'invoice_title', 'invoice_code', 'invoice_money', 'invoice_details', 'invoice_mail_address', 'invoice_mail_recipients', 'invoice_mail_mobile', 'invoice_mail_remark'];

                foreach ($teamList as $team) {
                    // dd($team['user']);
                    $team['user_name'] = $team['user']['name'];
                    $team['user_mobile'] = $team['user']['mobile'];
                    $team['user_email'] = $team['user']['email'];

                	$memberCount = $team->members->count();
                	$idx = 0;
                	foreach ($team->members as $m) {
                		$sheet->row($rowIndex + $idx++, [
                			'', '', '', '', '', '', '', '', '', '', '', '',
                			$m['type'] == 'leader' ? '领队教师' : '学生',
                			$m['name'],
                			$m['sex'],
                            $m['age'],
                            $m['school'],
                			$m['class'],
                			$m['work_unit'],
                			$m['idcard_type'],
                			$m['idcard_no'].' ',
                            $m['guarder'],
                            $m['relation'],
                			$m['home_address'],
                			$m['mobile'].' ',
                            $m['email'],
                			$m['headmaster'],
                			$m['remark']
                			]);
                	}

                    for ($i=0; $i < 11; $i++) {
                        $colName = $columns[$i];
                        $keyName = $columnKeys[$i];

                        $sheet->setMergeColumn([
                                'columns' => [$colName],
                                'rows'    => [
                                    [$rowIndex, $rowIndex + $idx],
                                ]
                            ]);
                        if ($keyName == 'team_no' || $keyName == 'contact_mobile') {
                            $sheet->cell($colName.$rowIndex, $team[$keyName].' ');
                        } else {
                            $sheet->cell($colName.$rowIndex, $team[$keyName]);
                        }
                    }

                    for ($i=0; $i < 9; $i++) {
                        $colName = $invoice[$i];
                        $keyName = $invoiceKeys[$i];

                        $sheet->setMergeColumn([
                                'columns' => [$colName],
                                'rows'    => [
                                    [$rowIndex, $rowIndex + $idx],
                                ]
                            ]);
                        // 筛选队伍然后添加开票详情
                        if ($team[$keyName] == '发票' || $team[$keyName] == '收据') {
                            $team['invoice_details'] = '参赛费';
                        }

                        $sheet->cell($colName.$rowIndex, $team[$keyName].' ');
                    }

                	$rowIndex = $rowIndex + $idx + 1;
                }

                $arr = [];
                foreach ($columns as $col) {
                    $arr[$col] = 20;
                }

                $sheet->setWidth($arr);

            });
            //最后一步 导出excel 表格
        })->export('xls');
    }


}
