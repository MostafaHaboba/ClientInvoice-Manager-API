<?php

namespace App\Filters;


use Illuminate\Http\Request;

class ApiFilter{
    protected $safeParms=[];

    protected $coulmnMap =[];
    protected $operatorMap =[];
    public function transform(Request $request){
        $eloQuery=[];

        foreach($this->safeParms as $parm=>$operators){
            $query=$request->query($parm);

            if(!isset($query)){
                continue;
            }

            $coulmn=$this->coulmnMap[$parm]??$parm;

            foreach($operators as $operator){
                if (isset($query[$operator])){
                    $eloQuery[]=[$coulmn,$this->operatorMap[$operator],$query[$operator]];
                }
            }

        }

        return $eloQuery;
    }
}