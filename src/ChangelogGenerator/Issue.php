<?php

declare(strict_types=1);

namespace ChangelogGenerator;

use function sprintf;

class Issue
{
    private const SINGLE_CONTRIBUTOR_ISSUE_LINE_FORMAT = ' - [%d: %s](%s) thanks to @%s';
    private const MULTI_CONTRIBUTOR_ISSUE_LINE_FORMAT  = ' - [%d: %s](%s) thanks to @%s and @%s';

    /** @var int */
    private $number;

    /** @var string */
    private $title;

    /** @var string */
    private $body;

    /** @var string */
    private $url;

    /** @var string */
    private $user;

    /** @var string[] */
    private $labels = [];

    /** @var bool */
    private $isPullRequest;

    /** @var Issue|null */
    private $linkedPullRequest;

    /** @var Issue|null */
    private $linkedIssue;

    /**
     * @param string[] $labels
     */
    public function __construct(
        int $number,
        string $title,
        string $body,
        string $url,
        string $user,
        array $labels,
        bool $isPullRequest
    ) {
        $this->number        = $number;
        $this->title         = $title;
        $this->body          = $body;
        $this->url           = $url;
        $this->user          = $user;
        $this->labels        = $labels;
        $this->isPullRequest = $isPullRequest;
    }

    public function getNumber() : int
    {
        return $this->number;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getBody() : string
    {
        return $this->body;
    }

    public function getUrl() : string
    {
        return $this->url;
    }

    public function getUser() : string
    {
        return $this->user;
    }

    /**
     * @return string[]
     */
    public function getLabels() : array
    {
        return $this->labels;
    }

    public function isPullRequest() : bool
    {
        return $this->isPullRequest;
    }

    public function getLinkedPullRequest() : ?Issue
    {
        return $this->linkedPullRequest;
    }

    public function setLinkedPullRequest(Issue $linkedPullRequest) : void
    {
        $this->linkedPullRequest = $linkedPullRequest;
    }

    public function getLinkedIssue() : ?Issue
    {
        return $this->linkedIssue;
    }

    public function setLinkedIssue(Issue $linkedIssue) : void
    {
        $this->linkedIssue = $linkedIssue;
    }

    public function render() : string
    {
        if ($this->linkedIssue instanceof self && $this->linkedIssue->getUser() !== $this->user) {
            return sprintf(
                self::MULTI_CONTRIBUTOR_ISSUE_LINE_FORMAT,
                $this->number,
                $this->title,
                $this->url,
                $this->user,
                $this->linkedIssue->getUser()
            );
        }

        return sprintf(
            self::SINGLE_CONTRIBUTOR_ISSUE_LINE_FORMAT,
            $this->number,
            $this->title,
            $this->url,
            $this->user
        );
    }
}
