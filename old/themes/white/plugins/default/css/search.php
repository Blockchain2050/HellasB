.ossn-search {
   display:inline-block;
   width:60%;
   margin:11px;
}
.ossn-search input[type='text']{
    width: 100%;
    margin: 0 auto;
    color: var(--text-color);
    border-radius: 30px;
    background: var(--bg-input-bg);
    border: 0;
    padding-left: 11px;
    padding: 9px;
	font-family: FontAwesome;    
}
.ossn-search input[type='text']:focus::placeholder {
  color: transparent;
}
.ossn-search:focus-within {
	width:65%;
}
.search-topbar-sm .ossn-search {
	width:70%;
}
.search-topbar-sm .ossn-search:focus-within {
	width:90%;
}