<!DOCTYPE html>

<html>
<head>
    <title>On The Spot Package Delivery | Package Details</title>
    <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<header id="header">

    <h1 id="logo"><a href="">On The Spot</a></h1>

</header>

<body>
   <!-- Columns:
orderID int(255) AI PK
userID int(255) PK
orderStatus varchar(255)
description varchar(140)
totalWeight int(4)
signature tinyint(1)
deliveryPriority varchar(255)
pickUpAddress varchar(255)
pickUptime timestamp
deliveryAddress varchar(255)
recipientName varchar(255)
recipientphoneNo int(16)-->
    <div class="container">
        <h2>Order Details</h2>
        <form>
            <div class="form-group">
                <label for="comment">Description:</label>
                <textarea class="form-control" rows="5" id="comment"></textarea>*max 140 characters
            </div>

            <div class="form-group">
                <label for="weight">Weight:</label>
                <input type="number" class="form-control" id="weight" name="totalWeight" placeholder="Weight in KGs">KGs
            </div>

            <div class="form-group">
                <label>Require Signature Upon Delivery?</label>
                <label class="radio-inline"><input type="radio" name="optradio">Yes</label>
                <label class="radio-inline"><input type="radio" name="optradio">No</label>
            </div>

            <div class="form-group">
                <label>Delivery Priority</label>
                <div class="radio">
                    <label><input type="radio" name="optradio">Express (1-2 Business Days)</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="optradio">Standard (5-7 Business Days)</label>
                </div>
            </div>

            <h3>Pick Up</h3>

            <div class="form-group">
                <label>When:</label>
                <label class="radio-inline"><input type="radio" name="optradio">Immediate</label>
                <label class="radio-inline"><input type="radio" name="optradio">Later</label>
            </div>

            <div class="form-group">
                <label for="sel1">Pickup Day:</label>
                <select class="form-control" id="sel1">
                    <option>- Select Day -</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                    <option>11</option>
                    <option>12</option>
                    <option>13</option>
                    <option>14</option>
                    <option>15</option>
                    <option>16</option>
                    <option>17</option>
                    <option>18</option>
                    <option>19</option>
                    <option>20</option>
                    <option>21</option>
                    <option>22</option>
                    <option>23</option>
                    <option>24</option>
                    <option>25</option>
                    <option>26</option>
                    <option>27</option>
                    <option>28</option>
                    <option>29</option>
                    <option>30</option>
                    <option>31</option>
                    </select>
                    </div>

                    <div class="form-group">
                    <label for="sel1">Pickup Month:</label>
                    <select class="form-control" id="sel1">
                    <option>- Select Month -</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                    <option>11</option>
                    <option>12</option>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Pickup Year:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Year">
            </div>

            <div class="form-group">
                <label for="sel1">Estimated Time of Pickup:</label>
                <select class="form-control" id="sel1">
                    <option>- Select Hour -</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                    <option>11</option>
                    <option>12</option>
                </select>
            </div>

            <div class="form-group">
                <label for="sel1">Estimated Time of Pickup:</label>
                <select class="form-control" id="sel1">
                    <option>- Select Minute -</option>
                    <option>00</option>
                    <option>15</option>
                    <option>30</option>
                    <option>45</option>
                </select>
            </div>

            <div class="form-group">
                <label for="sel1">Estimated Time of Pickup:</label>
                <select class="form-control" id="sel1">
                    <option>- Select -</option>
                    <option>AM</option>
                    <option>PM</option>
                </select>
            </div>

            <div class="form-group">
                <label>Where:</label>
                <label class="radio-inline"><input type="radio" name="optradio">Your Address</label>
                <label class="radio-inline"><input type="radio" name="optradio">Other</label>
            </div>

            <h3>Drop Off</h3>

            <div class="form-group">
                <label for="email">Recipient Name:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Recipient Name">
            </div>

            <div class="form-group">
                <label for="email">Recipient Phone Number:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Phone Number">
            </div>


            <h3>Address</h3>

            <div class="form-group">
                <label for="email">Unit Number:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Unit Number">
            </div>

            <div class="form-group">
                <label for="email">Street Name:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Street Name">
            </div>

            <div class="form-group">
                <label for="email">Suburb:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Suburb">
            </div>

            <div class="form-group">
                <label for="sel1">State:</label>
                <select class="form-control" id="sel1">
                    <option>- Select State -</option>
                    <option>QLD</option>
                    <option>NSW</option>
                    <option>ACT</option>
                    <option>VIC</option>
                    <option>SA</option>
                    <option>WA</option>
                    <option>NT</option>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Postcode:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Postcode">
            </div>

            <button type="submit" class="btn btn-default">Submit</button>

        </form>
    </div>

</body>
</html>
