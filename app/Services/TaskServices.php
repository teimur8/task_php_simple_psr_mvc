<?php

namespace App\Services;

use App\Model\Task;
use Framework\Http\Template\Paginator;
use Zend\Diactoros\ServerRequest;

class TaskServices
{
    public function get(ServerRequest $request)
    {
        $q = new Task();
        
        $params = $request->getQueryParams();
        if (!empty($params)) {
            foreach ($params as $k => $v) {
                if(!in_array($k, ['page']))
                    $q = $q->orderBy($k, $v);
            }
        }
        
        // pagination
        $currentPage = $params['page'] ? $params['page']:1;
        $paginator = new Paginator($q, 3, $currentPage);
        
        return $paginator;
    }
    
    public function create(ServerRequest $request)
    {
        return Task::create($request->getParsedBody());
    }
    
    public function show($id)
    {
        return Task::findOrFail($id);
    }
    
    public function update($getParsedBody, $id)
    {
        $item = $this->show($id);
        
        $temp['text'] = $getParsedBody['text'];
        $temp['is_done'] = $getParsedBody['is_done'] == 'true' ? true:false;
        
        $item->fill($temp);
        
        return $item->save();
    }
}
