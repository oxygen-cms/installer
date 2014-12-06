<?php

namespace Oxygen\Installer;

use Exception;
use Illuminate\Foundation\Application;
use Oxygen\Auth\Entity\Group;
use Oxygen\Auth\Entity\User;

class AccountConfigurer {

    /**
     * Constructs the configurer.
     *
     * @param Application $app
     */

    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * Creates a new user account.
     *
     * @param array $data
     * @throws Exception
     */

    public function configure(array $data) {
        $this->validate($data);

        $preferences = file_get_contents(__DIR__ . '/content/preferences-sample.json');
        $permissions = file_get_contents(__DIR__ . '/content/permissions-sample.json');

        $em = $this->app['Doctrine\ORM\EntityManager'];

        $em->transactional(function($em) use($permissions, $preferences, $data) {
            $em->createQuery('DELETE FROM Oxygen\Auth\Entity\User')->execute();
            $em->createQuery('DELETE FROM Oxygen\Auth\Entity\Group')->execute();

            $group = new Group();
            $group->setName('Administrator')
                  ->setDescription('Administrators have complete control over the system.')
                  ->setPreferences($preferences)
                  ->setPermissions($permissions);

            $em->persist($group);

            $user = new User();
            $user->setUsername($data['username'])
                 ->setPassword($data['password'])
                 ->setFullName($data['fullName'])
                 ->setEmail($data['email'])
                 ->setGroup($group)
                 ->setPreferences($preferences);

            $em->persist($user);
        });
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
            'username' => ['required', 'min:4', 'max:50', 'alpha_num'],
            'fullName' => ['required', 'min:3', 'max:100', 'name'],
            'email' => ['required', 'email', 'max:100']
        ]);

        if($validator->fails()) {
            throw new InvalidDataException($validator->errors());
        }
    }

}
