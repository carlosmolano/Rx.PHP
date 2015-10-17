<?php

namespace Rx\Disposable;

use Rx\DisposableInterface;

class SerialDisposable implements DisposableInterface
{
    private $isDisposed = false;

    /** @var DisposableInterface */
    private $disposable = null;

    function dispose()
    {
        if ($this->isDisposed) {
            return;
        }

        $this->isDisposed = true;
        $old = $this->disposable;
        $this->disposable = null;

        if ($old) {
            $old->dispose();
        }
    }

    /**
     * @return DisposableInterface
     */
    public function getDisposable()
    {
        return $this->disposable;
    }

    /**
     * @param DisposableInterface $disposable
     */
    public function setDisposable(DisposableInterface $disposable)
    {
        $shouldDispose = $this->isDisposed;
        if (!$shouldDispose) {
            $old = $this->disposable;
            $this->disposable = $disposable;
            if ($old) {
                $old->dispose();
            }
        }

        if ($shouldDispose) {
            $disposable->dispose();
        }
    }
}