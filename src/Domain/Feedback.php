<?php

namespace LabCoding\Feedback\Domain;

use T4webDomain\Entity;

class Feedback extends Entity
{

    const STATUS_NEW = 1;
    const STATUS_ANSWERED = 2;

    /**
     * @var array
     */
    public static $statuses = [
        self::STATUS_NEW => 'new',
        self::STATUS_ANSWERED => 'answer sent',
    ];

    protected $name;
    protected $email;
    protected $message;
    protected $answer;
    protected $createdDt;
    protected $updatedDt;
    protected $status;

    public function __construct(array $data = [])
    {
        if (empty($data['id'])) {
            $data['createdDt'] = date('Y-m-d H:i:s');
            $data['updatedDt'] = date('Y-m-d H:i:s');
            $data['status'] = self::STATUS_NEW;
        }

        parent::__construct($data);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @return mixed
     */
    public function getCreatedDt()
    {
        return $this->createdDt;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     */
    public function setAnswered()
    {
        $this->status = self::STATUS_ANSWERED;
    }

    /**
     * @return bool
     */
    public function isAnswered()
    {
        return (bool)($this->status == self::STATUS_ANSWERED);
    }

}