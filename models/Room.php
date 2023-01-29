<?php

Class Room extends Model {

    protected $table = 'room';

    public function roomsWithImages(){
        $data = [];
        $all = $this->all();

        foreach ($all as $key => $value) {
            $id = $value['id'];
            $value['other_images'] = $this->setQuery("
                                                SELECT B.* 
                                                FROM `room` A
                                                INNER JOIN `room_other_images` B
                                                ON A.id = B.room_id
                                                WHERE A.id = $id
                                                ")
                                                ->getAll();

        array_push($data, $value);

        }

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';

        return $data;
                
    }
    
}