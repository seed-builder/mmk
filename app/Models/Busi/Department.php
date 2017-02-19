<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;

/**
 * 部门
 * Class Department
 * @package App\Models\Busi
 * @author xrs
 * @SWG\Model(id="Department")
 * @SWG\Property(name="fauditor_id", type="integer", description="fauditor_id")
 * @SWG\Property(name="faudit_date", type="string", description="faudit_date")
 * @SWG\Property(name="fcreate_date", type="string", description="fcreate_date")
 * @SWG\Property(name="fcreator_id", type="integer", description="fcreator_id")
 * @SWG\Property(name="fdocument_status", type="integer", description="fdocument_status")
 * @SWG\Property(name="fforbidder_id", type="integer", description="fforbidder_id")
 * @SWG\Property(name="fforbid_date", type="string", description="fforbid_date")
 * @SWG\Property(name="fforbid_status", type="integer", description="fforbid_status")
 * @SWG\Property(name="ffullname", type="string", description="ffullname")
 * @SWG\Property(name="fmodify_date", type="string", description="fmodify_date")
 * @SWG\Property(name="fmodify_id", type="integer", description="fmodify_id")
 * @SWG\Property(name="fname", type="string", description="fname")
 * @SWG\Property(name="fnumber", type="string", description="fnumber")
 * @SWG\Property(name="fpardept_id", type="integer", description="fpardept_id")
 * @SWG\Property(name="fremark", type="string", description="fremark")
 * @SWG\Property(name="id", type="integer", description="id")
 */
class Department extends BaseModel
{
    //
    protected $table = 'bd_departments';

    protected $with = ['organization'];

    public $validateRules = ['fname' => 'required', 'fnumber' => 'required', 'ffullname' => 'required'];

    public function organization()
    {
        return $this->hasOne(Organization::class, 'id', 'forg_id');
    }

    public function child_depart($id)
    {
        return Department::query()
            ->where('fpardept_id', $id)
            ->get();
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'fdept_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Department::class, 'fpardept_id');
    }

    //查询部门下的所有部门
    public function getAllChildDept()
    {
        $id = $this->id;
        $dept = Department::find($this->id);
        $ids = $this->getTreeChilds($dept);
        $ids[] = $dept->id;

        return Department::query()->whereIn('id',$ids)->get();
    }

    //查询部门下的所有员工 包含子部门
    public function getAllEmployeeByDept()
    {
        $id = $this->id;
        $dept = Department::find($this->id);
        $ids = $this->getTreeChilds($dept);
        $ids[] = $dept->id;

        return Employee::query()->whereIn('fdept_id',$ids)->get();
    }

    public function getTreeChilds($entity)
    {
        global $ids;
        $childs = $entity->children;
        foreach ($childs as $c) {

            $ids[] = $c->id;
            if (!empty($c->children)) {
                $this->getTreeChilds($c);
            }
        }

        return $ids;
    }


}
