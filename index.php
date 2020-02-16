<?php

require_once dirname(__FILE__).'/lib/limonade.php';
require_once dirname(__FILE__).'/lib/faker.php';

dispatch('/', 'get');
    function get() {
        $string = file_get_contents("./data.json");
        $persons = json_decode($string, true);
        return json($persons);
    }

dispatch_post('/', 'addPerson'); 
    function addPerson(){
        return get();
    }
    
dispatch_put('/', 'update'); 
    function update(){
        // Update something
        $faker = Faker\Factory::create();
        $faker->addProvider(new Faker\Provider\fr_FR\Person($faker));
        $faker->addProvider(new Faker\Provider\fr_FR\Address($faker));
        $faker->addProvider(new Faker\Provider\fr_FR\PhoneNumber($faker));
        $faker->addProvider(new Faker\Provider\fr_FR\Internet($faker));
        $persons = array();
        for ($i=0; $i < 5; $i++) { 
            $person = [
                'age' => $faker->numberBetween(18, 85),
                'name' => $faker->name(),
                'address'=> $faker->address(),
                'phoneNumber'=> $faker->phoneNumber(),
                'email' => $faker->email(),
                'avatar' => $faker->imageUrl(200, 200),
            ];
            array_push($persons, $person);
        }
        file_put_contents("./data.json", json_encode($persons));
        return html("Liste réintialisée !");
    }
    
dispatch_delete('/', 'delete'); 
    function delete() {
        $string = file_get_contents("./data.json");
        $persons = json_decode($string, true);
        array_pop($persons);
        file_put_contents("./data.json", json_encode($persons));
        return html("Personne supprimée !");
    }
  
run();
