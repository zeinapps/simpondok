<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $allRoute = \Route::getRoutes();
        foreach ($allRoute as $route) {
            $attributes = $route->getAction();
            $name = $route->getName();
            $display_name = isset($attributes['display_name']) ? $attributes['display_name'] : null;
            $description = isset($attributes['description']) ? $attributes['description'] : null;
            if(!strpos($name,'ermission')){
                continue;
            }
            if(\App\Models\Permission::where('name',$name)->first()){
                continue;
            }
            \App\Models\Permission::create([
                        'name' => $name,
                        'display_name' => $display_name,
                        'description' => $description,
                    ]
                );
        }
    }
}
