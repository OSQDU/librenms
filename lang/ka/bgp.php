<?php

// https://www.iana.org/assignments/bgp-parameters/bgp-parameters.xhtml#bgp-parameters-3
return [
    'error_codes' => [
        0 => 'დაცულია',
        1 => 'შეტყობინების თავსართის შეცდომა',
        2 => 'OPEN შეტყობინების შეცდომა',
        3 => 'UPDATE შეტყობინების შეცდომა',
        4 => 'მოლოდინის დრო ამოიწურა',
        5 => 'საბოლოო მანქანის შეცდომა',
        6 => 'შეწყვეტა',
        7 => 'ROUTE-REFRESH შეტყობინების შეცდომა',
    ],
    'error_subcodes' => [
        1 => [
            0 => 'მიუთითებელი',
            1 => 'კავშირი სინქრონიზებული არაა',
            2 => 'არასწორი შეტყობინების სიგრძე',
            3 => 'არასწორი შეტყობინების ტიპი',
        ],
        2 => [
            0 => 'მიუთითებელი',
            1 => 'მხარდაუჭერელი ვერსიის ნომერი',
            2 => 'პირის არასწორი AS',
            3 => 'არასწორი BGP-ის იდენტიფიკატორი',
            4 => 'მხარდაუჭერელი არასავალდებულო პარამეტრი',
            5 => '[მოძველებულია]',
            6 => 'მიუღებელი მოლოდინის დრო',
            7 => 'როლები არ ემთხვევა (BGP-ის მონახაზი)',
        ],
        3 => [
            0 => 'მიუთითებელი',
            1 => 'შეცდომების შემცველი ატრიბუტების სია',
            2 => 'უცნობი ატრიბუტი',
            3 => 'ნაკლული ატრიბუტი',
            4 => 'ატრიბუტის ალმების შეცდომა',
            5 => 'ატრიბუტის სიგრძლის შეცდომა',
            6 => 'არასწორი ატრიბუტი ORIGIN',
            7 => '[მოძველებულია]',
            8 => 'არასწორი ატრიბუტი NEXT_HOP',
            9 => 'არასავალდებულო ატრიბუტის შეცდომა',
            10 => 'არასწორი ქსელის ველი',
            11 => 'არასწორი AS_PATH',
        ],
        5 => [
            0 => 'მიუთითებელი შეცდომა',
            1 => 'მიღებულია მოულოდნელი შეტყობინება მდგომარეობაში OpenSent',
            2 => 'მიღებულია მოულოდნელი შეტყობინება მდგომარეობაში OpenConfirm',
            3 => 'მიღებულია მოულოდნელი შეტყობინება მდგომარეობაში Established',
        ],
        6 => [
            0 => 'დარეზერვებულია',
            1 => 'მიღწეულია პრეფიქსების მაქს. რაოდენობა',
            2 => 'ადმინისტრაციული გამორთვა',
            3 => 'პირი წაიშალა კონფიგურაციიდან',
            4 => 'ადმინისტრაციული ჩამოყრა',
            5 => 'კავშირი უარყოფილია',
            6 => 'კონფიგურაციის ცვლილება',
            7 => 'კავშირის კოლიზიის გადაწყვეტა',
            8 => 'არასაკმარისი რესურსები',
            9 => 'მყარი ჩამოყრა',
        ],
    ],
];
