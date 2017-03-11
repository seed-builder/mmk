<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;
use App\Services\LogSvr;

/**
 * 门店
 * Class Store
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="Store")
 * @SWG\Property(name="faccountnum", type="string", description="账户")
 * @SWG\Property(name="faddress", type="string", description="详细地址")
 * @SWG\Property(name="farea", type="string", description="面积")
 * @SWG\Property(name="farea_unit", type="string", description="单位")
 * @SWG\Property(name="fauditor_id", type="integer", description="审核人")
 * @SWG\Property(name="faudit_date", type="string", description="审核日期")
 * @SWG\Property(name="fbankaccount", type="string", description="开户银行")
 * @SWG\Property(name="fbusslicense", type="string", description="营业执照")
 * @SWG\Property(name="fchannel", type="integer", description="渠道分类")
 * @SWG\Property(name="fcity", type="string", description="城市")
 * @SWG\Property(name="fcontracts", type="string", description="联系人")
 * @SWG\Property(name="fcountry", type="string", description="区县")
 * @SWG\Property(name="fcreate_date", type="string", description="创建时间")
 * @SWG\Property(name="fcreator_id", type="integer", description="创建人")
 * @SWG\Property(name="fcust_id", type="integer", description="客户id")
 * @SWG\Property(name="fdocument_status", type="integer", description="审核状态")
 * @SWG\Property(name="fdutyparagraphe", type="string", description="税号")
 * @SWG\Property(name="femail", type="string", description="联系人email")
 * @SWG\Property(name="femp_id", type="integer", description="负责业务员")
 * @SWG\Property(name="ffax", type="string", description="联系人传真")
 * @SWG\Property(name="fforbidder_id", type="integer", description="禁用人")
 * @SWG\Property(name="fforbid_date", type="string", description="禁用日期")
 * @SWG\Property(name="fforbid_status", type="integer", description="禁用状态")
 * @SWG\Property(name="ffullname", type="string", description="全名")
 * @SWG\Property(name="flatitude", type="string", description="纬度")
 * @SWG\Property(name="flevel", type="integer", description="门店等级")
 * @SWG\Property(name="flongitude", type="string", description="经度")
 * @SWG\Property(name="fmode", type="integer", description="配送模式")
 * @SWG\Property(name="fmodify_date", type="string", description="修改时间")
 * @SWG\Property(name="fmodify_id", type="integer", description="修改人")
 * @SWG\Property(name="fnumber", type="string", description="编号")
 * @SWG\Property(name="forg_id", type="integer", description="组织id")
 * @SWG\Property(name="fphone", type="string", description="联系人手机")
 * @SWG\Property(name="fphoto", type="integer", description="门店图片")
 * @SWG\Property(name="fpostalcode", type="string", description="邮编")
 * @SWG\Property(name="fprovince", type="string", description="省份")
 * @SWG\Property(name="fremark", type="string", description="描述")
 * @SWG\Property(name="fshortname", type="string", description="简称")
 * @SWG\Property(name="fstreet", type="string", description="街道")
 * @SWG\Property(name="ftelephone", type="string", description="联系人电话")
 * @SWG\Property(name="ftitle", type="string", description="联系人职位")
 * @SWG\Property(name="ftran_cust_id", type="integer", description="配送商id")
 * @SWG\Property(name="fis_signed", type="integer", description="是否签约")
 * @SWG\Property(name="id", type="integer", description="")
 */
class Store extends BaseModel
{
    //
    protected $table = 'st_stores';
    
    //protected $with = ['employee','customer', 'lines','channel','photo'];
    
    public $validateRules=[
    		'ffullname' => 'required',
    		'fcontracts' => 'required',
    		'ftelephone' => 'required',
    		'faddress' => 'required',
    		'fpostalcode' => 'required',
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'fcust_id');
    }
    
    public function employee(){
    	return $this->belongsTo(Employee::class, 'femp_id');
    }

    public function lines(){
    	return $this->belongsToMany(VisitLine::class, 'visit_line_store', 'fstore_id', 'fline_id');
    }

    public function channel(){
        return $this->hasOne(Channel::class, 'id', 'fchannel');
    }

    public function photo(){
        return $this->hasOne(Resources::class, 'id', 'fphoto');
    }

	public function displayPolicies(){
		return $this->hasMany(DisplayPolicyStore::class, 'fstore_id', 'id');
	}

    protected static function boot()
    {
	    // TODO: Change the autogenerated stub
	    static::created(function ($store) {
	    	if($store->fline_id) {
			    VisitLineStore::create([
			    	'fline_id' => $store->fline_id,
				    'fstore_id' => $store->id,
				    'femp_id' => $store->femp_id
				    ]
			    );
		    }
	    });

	    static::updating(function ($store) {
		    //LogSvr::storeUpdate()->info(json_encode($store));
	    	if($store->fline_id){
				$entity = VisitLineStore::where('fstore_id', $store->id)->first();
				if($entity){
					$entity->fill(['fline_id' => $store->fline_id]);
					$entity->save();
				}else{
					VisitLineStore::create([
							'fline_id' => $store->fline_id,
							'fstore_id' => $store->id,
							'femp_id' => $store->femp_id
						]
					);
				}
		    }else{
	    		$entities = VisitLineStore::where('fstore_id', $store->id)->get();
	    		$ids = $entities->map(function ($item){
	    			return $item->id;
			    });
	    		VisitLineStore::destroy($ids);
		    }
	    });

	    static::deleted(function ($store) {
		    $entities = VisitLineStore::where('fstore_id', $store->id)->get();
		    $ids = $entities->map(function ($item){
			    return $item->id;
		    });
		    VisitLineStore::destroy($ids);
	    });
	    //parent::boot();
    }
}
