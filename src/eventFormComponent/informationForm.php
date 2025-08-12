<html>
<div id="grid-form">
    <div class="grid-item">
        <label for="event-name">Event name</label><br />
        <input class="form-control" type="text" id="event-name" name="event-name" maxlength="20"
            oninput="resetError('event-name')" required />
    </div>
    <div class="grid-item">
        <label>Your Contact number</label><br />
        <select name="countryCode" id="select-country" required />
        <option data-countryCode="MY" value="60">Malaysia (+60)</option>
        <br />
        <input class="form-control" type="number" min="0" id="contact-number" name="contact-number"
            onkeypress="return validateNumber(event)" oninput="resetError('contact-number')" required /><br />
    </div>
    <div class="grid-item">
        <label>Start date</label><br />
        <input class="form-control" type="date" id="start-date" name="start-date" onchange="resetError('start-date')"
            required /><br />
    </div>
    <div class="grid-item">
        <label>End date</label><br />
        <input class="form-control" type="date" id="end-date" name="end-date" onchange="resetError('end-date')"
            required /><br />
    </div>
    <div class="grid-item">
        <label>Start time</label><br />
        <input class="form-control" type="time" id="start-time" name="start-time" onchange="resetError('start-time')"
            required /><br />
    </div>
    <div class="grid-item">
        <label>End time</label><br />
        <input class="form-control" type="time" id="end-time" name="end-time" onchange="resetError('end-time')"
            required /><br />
    </div>
    <div class="grid-item">
        <label>Venue</label><br />
        <input class="form-control" type="text" id="venue" name="venue" maxlength="40" oninput="resetError('venue')"
            required /><br />
    </div>
    <div class="grid-item">
        <label>Number of guests</label><br />
        <input class="form-control" type="number" min="1" max="10000" id="guest" name="guest"
            onkeypress="return validateNumber(event)" oninput="resetError('guest')" required /><br />
    </div>
</div>

</html>