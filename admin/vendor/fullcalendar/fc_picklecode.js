function columnHeaderText_pickle(mom) {
    switch(mom.weekday()){
        case 0: return "일";
        case 1: return "월";
        case 2: return "화";
        case 3: return "수";
        case 4: return "목";
        case 5: return "금";
        case 6: return "토";
    }
}

var monthNames_pickle = ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'];

var example_json = [{"title":"All Day Event","start":"2018-08-01"},{"title":"Long Event","start":"2018-08-07","end":"2018-08-10"},{"id":999,"title":"Repeating Event","start":"2018-08-09T16:00:00+00:00"},{"id":999,"title":"Repeating Event","start":"2018-08-16T16:00:00+00:00"},{"title":"Conference","start":"2018-08-12","end":"2018-08-14"},{"title":"Meeting","start":"2018-08-13T10:30:00+00:00","end":"2018-08-13T12:30:00+00:00"},{"title":"Lunch","start":"2018-08-13T12:00:00+00:00"},{"title":"Birthday Party","start":"2018-08-14T07:00:00+00:00"},{"url":"http:\/\/google.com\/","title":"Click for Google","start":"2018-08-28"}];