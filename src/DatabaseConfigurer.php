<?php

namespace Oxygen\Installer;

use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Support\MessageBag;

class DatabaseConfigurer {

    /**
     * Constructs the configurer.
     *
     * @param Application $app
     */

    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * Configures the database connection using the given data.
     *
     * @param array $data
     * @throws Exception
     */

    public function configure(array $data) {
        $passed = $this->validate($data);

        if($passed !== true) {
            var_dump($passed);
            die();
        }

        $this->app['config']->set('database.connections.' . $data['driver'], $this->getDatabaseConfig($data));

        die('has set');

        $em = $this->app['Doctrine\ORM\EntityManager'];
        $sm = $em->getConnection()->getSchemaManager();
        var_dump($sm->listTables());
    }

    /**
     * Validates the input data.
     *
     * @param $data
     * @return boolean|MessageBag
     */

    protected function validate($data) {
        $validator = $this->app['validator']->make($data, [
            'driver' => ['required', 'in:mysql,postgres,sqlite,sqlserver'],
            'database' => ['required']
        ]);

        $validator->sometimes(['host', 'username', 'password'], 'required', function($input) {
            return $input['driver'] !== 'sqlite';
        });

        if($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }

    /**
     * Returns the Laravel-style config for the database.
     * 
     * @param array $input
     * @return array
     */
    
    protected function getDatabaseConfig(array $input) {
        $connection = [];

        if($input['driver'] === 'mysql' || $input['driver'] === 'pgsql' || $input['driver' === 'sqlsrv']) {
            $connection = [
                'driver'    => $input['driver'],
                'host'      => $input['host'],
                'database'  => $input['database'],
                'username'  => $input['username'],
                'password'  => $input['password'],
                'prefix'    => '',
            ];
        }

        if($input['driver'] === 'sqlite') {
            $connection = [
                'driver'   => $input['driver'],
			    'database' => INSTALL_PATH . $input['database'],
			    'prefix'   => ''
            ];
        }

        if($input['driver'] === 'mysql' || $input['driver'] === 'pgsql') {
            $connection['charset'] = 'utf8';
        }

        if($input['driver'] === 'mysql') {
            $connection['collation'] = 'utf8_unicode_ci';
        }

        if($input['driver'] === 'pgsql') {
            $connection['schema'] = 'public';
        }

        return $connection;
    }

}
