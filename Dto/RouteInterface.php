<?php

namespace Dto;

interface RouteInterface
{
    public function getControllerClass(): string;
    public function getAction(): string;
    public function getParams(): array;
    public function generateUrl(): string;
}