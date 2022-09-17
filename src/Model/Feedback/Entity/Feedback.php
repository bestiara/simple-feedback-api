<?php

declare(strict_types=1);

namespace App\Model\Feedback\Entity;

use DateTimeImmutable;

/**
 * Отзыв
 *
 * @author Dmitry Nikolsky <dmitry.nickolskiy@gmail.com>
 */
class Feedback
{
    private FeedbackId $id;
    private string $name;
    private string $phone;
    private string $ip;
    private DateTimeImmutable $createdAt;

    /**
     * @param FeedbackId $id Идентификатор
     * @param string $name Имя
     * @param string $phone Телефон
     * @param string $ip IP-адрес
     */
    public function __construct(FeedbackId $id, string $name, string $phone, string $ip)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->ip = $ip;

        $this->createdAt = new DateTimeImmutable();
    }

    /**
     * Идентификатор
     */
    public function getId(): FeedbackId
    {
        return $this->id;
    }

    /**
     * Имя
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Телефон
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * IP-адрес
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * Дата создания.
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
