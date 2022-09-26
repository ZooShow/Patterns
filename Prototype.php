<?php

declare(strict_types=1);

class User
{
    private string $name;
    private string $secondName;
    /**
     * @var Page[]
     */
    private array $pages;

    public function __construct(string $name, string $secondName)
    {
        $this->name = $name;
        $this->secondName = $secondName;
    }

    public function addPage(Page $page)
    {
        $this->pages[] = $page;
    }

    public function getPages(): self
    {
        foreach ($this->pages as $page) {
            echo 'Title: ' . $page->getTitle(), ' text: ' . $page->getText() . PHP_EOL;
        }
        return $this;
    }
}

class Page
{
    private string $title;
    private string $text;
    private User $author;

    public function __construct(string $title, string $text, User $author)
    {
        $this->title = $title;
        $this->text = $text;
        $this->author = $author;
        $this->author->addPage($this);
    }

    public function __clone()
    {
        $this->title = 'Копия ' . $this->title;
        $this->author->addPage($this);
        $this->text = $this->text;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }
}

$author = new User('Foo', 'Bar');

$a = new Page('title', 'text', $author);
$b = clone $a;

$author->getPages();