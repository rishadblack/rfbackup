<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ServerMonitor extends Command
{
    protected $signature = 'server:monitor {token= : Reseller Forge API token} {serverId : Reseller Forge Server Id}';
    protected $description = 'Reseller Forge Server Monitoring System';

    public function handle()
    {
        $this->info(base_path());
        return base_path();

        $this->sites = [
            // 'allbrandshoe',
            // 'anh',
            'ar_group',
            'asialinkindustry_db',
            'aziz',
            'backup_madina',
            'borhancycle',
            'business_accounting_demo',
            'cactus',
            'cafe_711',
            'chalchitra',
            'designtouch'
        ];

        foreach ($this->sites as $site) {
            $this->setupConfigForSite($site);
            $this->callBackupCommand();
        };
    }

    protected function setupConfigForSite($site)
    {
        Config::set('backup.backup.name', $this->siteName($site));
        Config::set('backup.backup.destination.filename_prefix', $site.'_');
        Config::set('backup.backup.source.databases', ['servers']);
        Config::set('database.connections.servers.host', '178.128.102.119');
        Config::set('database.connections.servers.database', $site);
        Config::set('database.connections.servers.username', 'forge');
        Config::set('database.connections.servers.password', 'w7441lSlPHnsakWttlI7');
    }

    protected function siteName($site)
    {
        return $site;
    }

    protected function callBackupCommand()
    {
        $this->call('backup:'.$this->backupType());
    }

    protected function backupType()
    {
        return $this->option('clean') ? 'clean' : 'run';
    }
}
