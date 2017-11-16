<?php

/*
 * This file is part of ConfigServiceProvider.
 *
 * (c) Igor Wiedler <igor@wiedler.ch>
 *
 * Fred Dysart: Updated and simplified for use with Silex 2.0 & just YAML.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bookshelf\Provider;


use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Yaml\Yaml;

class ConfigServiceProvider implements ServiceProviderInterface
{
    private $filename;
    private $replacements = array();
    private $prefix = null;

    public function __construct($filename, array $replacements = array(), $prefix = null) {
        $this->filename = $filename;
        $this->prefix = $prefix;

        if ($replacements) {
            foreach ($replacements as $key => $value) {
                $this->replacements['%'.$key.'%'] = $value;
            }
        }
    }

    public function register(Container $app) {
        $config = $this->readConfig();

        foreach ($config as $name => $value) {
            if ('%' === substr($name, 0, 1)) {
                $this->replacements[$name] = (string) $value;
            }
        }

        $this->merge($app, $config);
    }

    private function merge(Container $app, array $config) {
        if ($this->prefix) {
            $config = array($this->prefix => $config);
        }

        foreach ($config as $name => $value) {
            if (isset($app[$name]) && is_array($value)) {
                $app[$name] = $this->mergeRecursively($app[$name], $value);
            } else {
                $app[$name] = $this->doReplacements($value);
            }
        }
    }

    private function mergeRecursively(array $currentValue, array $newValue) {
        foreach ($newValue as $name => $value) {
            if (is_array($value) && isset($currentValue[$name])) {
                $currentValue[$name] = $this->mergeRecursively($currentValue[$name], $value);
            } else {
                $currentValue[$name] = $this->doReplacements($value);
            }
        }

        return $currentValue;
    }

    private function doReplacements($value) {
        if (!$this->replacements) {
            return $value;
        }

        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = $this->doReplacements($v);
            }

            return $value;
        }

        if (is_string($value)) {
            return strtr($value, $this->replacements);
        }

        return $value;
    }

    private function readConfig() {
        if (!$this->filename) {
            throw new \RuntimeException('A valid configuration file must be passed before reading the config.');
        }

        if (!file_exists($this->filename)) {
            throw new \InvalidArgumentException(
                sprintf("The config file '%s' does not exist.", $this->filename));
        }

        return Yaml::parse(file_get_contents($this->filename));
    }
}
