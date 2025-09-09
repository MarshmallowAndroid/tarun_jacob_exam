<?php

namespace App;

enum DeliveryStatus: int
{
    case Pending = 0;
    case ForDelivery = 1;
    case Delivered = 2;
    case Cancelled = 3;
}
