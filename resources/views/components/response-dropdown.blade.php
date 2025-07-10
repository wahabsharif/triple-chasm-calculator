<style>
    select {
        width: 100%;
        height: 100%;
        box-sizing: border-box;
        border: none;
        color: black;
        vertical-align: middle;
        display: block;
        text-align: center;
        font-weight: bold;
        cursor: pointer;
    }

    select:focus {
        outline: none;
        border: none;
    }
</style>

<select name="{{ $name }}">
    <option value="Strongly disagree" @if ($selected === 'Strongly disagree') selected @endif>Strongly
        disagree</option>
    <option value="Disagree" @if ($selected === 'Disagree') selected @endif>Disagree</option>
    <option value="Neutral" @if ($selected === 'Neutral') selected @endif>Neutral</option>
    <option value="Agree" @if ($selected === 'Agree') selected @endif>Agree</option>
    <option value="Strongly agree" @if ($selected === 'Strongly agree') selected @endif>Strongly agree</option>
</select>
