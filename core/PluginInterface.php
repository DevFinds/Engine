<?php


namespace Core;
interface PluginInterface
{
	public function initialize(): void;
    public function shutdown(): void;
}