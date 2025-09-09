<?php

namespace App;

enum DeliveryStatus: int
{
    case Cancelled = -1;
    
    case Pending = 0;
    case ForDelivery = 1;
    case Delivered = 2;
}
