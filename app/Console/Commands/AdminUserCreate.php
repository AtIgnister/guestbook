<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Hash;

class AdminUserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:user:create
    {name : The user name}
    {email : The user email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new admin user for the guestbooks app.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ensure the admin role exists
        $role = Role::firstOrCreate(['name' => 'admin']);
        $password = $this->secret('Password');
        $email = $this->argument('email');

        if (! $this->confirm('Create admin user?')) {
            return -1;
        }

        if (User::where('email', $email)->exists()) {
            $this->error('User already exists.');
            return -1;
        }

        // Create user
        $user = User::create([
            'name' => $this->argument('name'),
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        
        // Assign admin role
        $user->assignRole($role);
        
        $this->info('Admin user created successfully!');
        $this->info("Email: {$user->email}");
    }
}
