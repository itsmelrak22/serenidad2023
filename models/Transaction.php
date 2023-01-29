<?php

Class Transaction extends Model {

    protected $table = 'transactions';
    
    public function getNotifData(){
        return $this->setQuery("SELECT
                        Count(A.id) as count
                        FROM `transactions` as A
                        LEFT JOIN `guest` as B
                        ON A.guest_id = B.id
                        LEFT JOIN `room` as C
                        ON A.room_id = C.id
                        WHERE A.status = 'Pending'
                        AND A.is_unread = 1
                        ")
                        ->getFirst();
                
    }

    public function getPendingTransactions(){
        return $this->setQuery("SELECT
                                A.*,
                                B.firstname,
                                B.middlename,
                                B.lastname,
                                B.address,
                                B.contactno,
                                C.room_type,
                                C.price,
                                C.photo
                                FROM `transactions` as A
                                LEFT JOIN `guest` as B
                                ON A.guest_id = B.id
                                LEFT JOIN `room` as C
                                ON A.room_id = C.id
                                WHERE A.status = 'Pending'
                                OR A.status = 'Expired'
                                ORDER BY A.created_at DESC
                                ")
                                ->getAll();
    }

    public function getReservedTransactions(){
        return $this->setQuery("SELECT
                                A.*,
                                B.firstname,
                                B.middlename,
                                B.lastname,
                                B.address,
                                B.contactno,
                                C.room_type,
                                C.price,
                                C.photo
                                FROM `transactions` as A
                                LEFT JOIN `guest` as B
                                ON A.guest_id = B.id
                                LEFT JOIN `room` as C
                                ON A.room_id = C.id
                                WHERE A.status = 'Reserved'
                                OR A.status = 'Cancelled'
                                ORDER BY A.created_at DESC
                                ")
                                ->getAll();
    }

    public function getExpiredTransactions(){
        return $this->setQuery("SELECT
                                A.*,
                                B.firstname,
                                B.middlename,
                                B.lastname,
                                B.address,
                                B.contactno,
                                C.room_type,
                                C.price,
                                C.photo
                                FROM `transactions` as A
                                LEFT JOIN `guest` as B
                                ON A.guest_id = B.id
                                LEFT JOIN `room` as C
                                ON A.room_id = C.id
                                WHERE A.status = 'Expired'
                                ORDER BY A.created_at DESC
                                ")
                                ->getAll();
    }

    public function getCheckInTransactions(){
        return $this->setQuery("SELECT
                                A.*,
                                B.firstname,
                                B.middlename,
                                B.lastname,
                                B.address,
                                B.contactno,
                                C.room_type,
                                C.price,
                                C.photo
                                FROM `transactions` as A
                                LEFT JOIN `guest` as B
                                ON A.guest_id = B.id
                                LEFT JOIN `room` as C
                                ON A.room_id = C.id
                                WHERE A.status = 'Check In'
                                ORDER BY A.created_at DESC
                                ")
                                ->getAll();
    }

    public function getCheckOutTransactions(){
        return $this->setQuery("SELECT
                                A.*,
                                B.firstname,
                                B.middlename,
                                B.lastname,
                                B.address,
                                B.contactno,
                                C.room_type,
                                C.price,
                                C.photo
                                FROM `transactions` as A
                                LEFT JOIN `guest` as B
                                ON A.guest_id = B.id
                                LEFT JOIN `room` as C
                                ON A.room_id = C.id
                                WHERE A.status = 'Check Out'
                                ORDER BY A.created_at DESC
                                ")
                                ->getAll();
    }
    
}