<?php

//echo $array["firstSubArray"]["SecondSubArray"]["ElementFromTheSecondSubArray"]
// ├─────────────┘  ├──────────────┘  ├────────────────────────────┘
// │                │                 └── 3rd Array dimension;
// │                └──────────────────── 2d  Array dimension;
// └───────────────────────────────────── 1st Array dimension;



//Arrays & Objects

//Now if you have arrays and objects mixed in each other you just have to look if you now access an array element or an object property and use the corresponding operator for it.

//Object
//echo $object->anotherObject->propertyArray["elementOneWithAnObject"]->property;
    //├────┘  ├───────────┘  ├───────────┘ ├──────────────────────┘   ├──────┘
    //│       │              │             │                          └── property ;
    //│       │              │             └───────────────────────────── array element (object) ; Use -> To access the property 'property'
    //│       │              └─────────────────────────────────────────── array (property) ; Use [] To access the array element 'elementOneWithAnObject'
    //│       └────────────────────────────────────────────────────────── property (object) ; Use -> To access the property 'propertyArray'
    //└────────────────────────────────────────────────────────────────── object ; Use -> To access the property 'anotherObject'




//Array
//echo $array["arrayElement"]["anotherElement"]->object->property["element"];
//├───┘ ├────────────┘  ├──────────────┘   ├────┘  ├──────┘ ├───────┘
//│     │               │                  │       │        └── array element ;
//│     │               │                  │       └─────────── property (array) ; Use [] To access the array element 'element'
//│     │               │                  └─────────────────── property (object) ; Use -> To access the property 'property'
//│     │               └────────────────────────────────────── array element (object) ; Use -> To access the property 'object'
//│     └────────────────────────────────────────────────────── array element (array) ; Use [] To access the array element 'anotherElement'
//└──────────────────────────────────────────────────────────── array ; Use [] To access the array element 'arrayElement'

