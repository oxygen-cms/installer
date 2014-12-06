<?php

namespace Oxygen\Installer;

use Exception;
use Illuminate\Foundation\Application;

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
        $this->validate($data);

        $this->testConnections($data);

        $this->buildSchema();
    }

    /**
     * Validates the input data.
     *
     * @param $data
     * @throws InvalidDataException
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
            throw new InvalidDataException($validator->errors());
        }
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
			    'database' => INSTALL_PATH . '/' . $input['database'],
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

    /**
     * Tests and configures database connections.
     *
     * @param array $data
     * @throws \Oxygen\Installer\InvalidDatabaseException
     */

    protected function testConnections(array $data) {
        $this->app['config']->set('database.connections.' . $data['driver'], $this->getDatabaseConfig($data));

        $em = $this->app['Doctrine\ORM\EntityManager'];
        $sm = $em->getConnection()->getSchemaManager();
        $tables = $sm->listTables();
        if(!empty($tables)) {
            throw new InvalidDatabaseException('Database "' . $data['database'] . '" is not empty');
        }

        $this->app['config']->write('database.connections.' . $data['driver'], $this->getDatabaseConfig($data));
    }

    /**
     * Builds the database schema.
     *
     * @return void
     */

    protected function buildSchema() {
        $schema = $this->app['Doctrine\ORM\Tools\SchemaTool'];
        $metadata = $this->app['Doctrine\ORM\Mapping\ClassMetadataFactory'];
        $schema->updateSchema($metadata->getAllMetadata());
    }

}
