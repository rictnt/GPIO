#GPIO manager

requires testing

The GPIO manager is designed to house your hardware environment setup and allow you to manager and interact with the hardware. 

The GPIO manager comes with a Laravel bridged service provider for easy integration with Laravel.

The GPIO class requires gpio to be installed 

Installing into laravel 

```$xslt
'providers' => [

    ...
    
    ChickenTikkaMasala\GPIO\Bridge\Laravel\GPIOServiceProvider::class,
    
    ...
    
];
```

Publish the vendor to get the config files

```$xslt
php artisan vendor:publish 
```
Example setup
```$xslt
    'pins' => [
        'redled' => [
            'pin' => 1,
            'mode' => 'pwm',
        ],
    ],
```
###Testing with the command line 

Turn the redled on pin 1 on full

```$xslt
php artisan gpio:set redled 1023
```
List all GPIO pin input from your setup
```$xslt
php artisan gpio:list
```
This will output an array of all the GPIOs setup with the manager

###Creating a new connection

Alternatively to config setup you can call the create function to add new connections. 

```$xslt
    public function index(GPIOManager $manager) 
    {
        $manager->create('greenled', 2);
        $manager->greenled = 'ON';
    }
```

The manager maps your named connections as parameters as shown above. When reading pins we canuse the same method with the parameters to get the result 

```$xslt
    public function index(GPIOManager $manager)
    {
        //create an analog sensor
        $manager->create('sensor', 3, 'aread');
        $value = $manager->sensor;
        
        return response()->json(['sensor' => $value]);
    }
```

Mapping also applies to the values 'OFF' and 'ON' where PWM expects 1023 as max and write expect 1. 'OFF' will equal to 0.

###Custom GPIO classes 

You can however add your own GPIO modes/classes in 2 ways. 

First being 

```$xslt
<?php 

use ChickenTikkaMasala\GPIO\GPIO;

class RedLED extends GPIO
{
    public function __construct()
    {
        parent::__construct(1, 'pwm', 'OFF');
    }
    
    public function getMethod()
    {
        return 'out';
    }
    
}
```

```$xslt
    public function index(GPIOManager $manager)
    {
        $redLED = new RedLED();
        $manager->add($redLED);
    }
```

Another method is to use the registerMode function to register the mode type for the manager so you can do something like this

```$xslt
    $manager->create('red', 1, 'LED');
```
Our GPIO config array in app/gpio.php [needs implementing]
```$xslt
    'modes' => [
        'LED' => \App\GPIO\Modes\LED::class,
    ],
```

###PWM functions

In PWM GPIO I have added 2 function for incrementing and decrementing for and to values within an interval. 
```$xslt
$manager->redled = 0;
$manager->redled->increment(1023, 200);
//redled will 'fade' from 0 to 1023 
//increment will increase every 200th millisecond

$manager->redled->decrement(0, 200);
```

###Terminal functions

- `gpio:set redled 500` => set red LED to 500
- `gpio:get sensor` => print the sensor reading
- `gpio:list` => list all connections
- `gpio:function redled increment 1023 1000` => call the increment function with the options

##Available default modes 

- PWM => for incrementing the voltage between 0 and max
- Awrite
- ARead
- Write => for writing to pins either OFF or ON (0v or max voltage)
- Read => for reading pins either OFF or ON 


#Coming soon

- Symfony bridge
- Caching the manager to store the setup and previously set states (to prevent overriding previously set values)
- Value managing (preventing > 1023 readings and writings)
