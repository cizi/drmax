<?php

class FeedItem {

    private int $id;

    private ?\DateTime $timestamp;
    
    private string $innerLink;

    private string $publicLink;

    private string $title;

    public function __contsruct() {
        // maybe create the object directly from constructor params instead of setters used in index.php, depends of next usage of this object :-) 
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTimestamp(): ?DateTime {
        return $this->timestamp;
    }

    public function getInnerLink(): string {
        return $this->innerLink;
    }

    public function getPublicLink(): string {
        return $this->publicLink;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setTimestamp(?DateTime $timestamp): void {
        $this->timestamp = $timestamp;
    }

    public function setInnerLink(string $innerLink): void {
        $this->innerLink = $innerLink;
    }

    public function setPublicLink(string $publicLink): void {
        $this->publicLink = $publicLink;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

}