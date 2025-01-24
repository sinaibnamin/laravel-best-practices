const blockManager = editor.Blocks;

blockManager.add('Big headline', {
    label: 'Big headline',
    media: `<svg viewBox="0 0 24 24">
<path fill="currentColor" d="M18.5,4L19.66,8.35L18.7,8.61C18.25,7.74 17.79,6.87 17.26,6.43C16.73,6 16.11,6 15.5,6H13V16.5C13,17 13,17.5 13.33,17.75C13.67,18 14.33,18 15,18V19H9V18C9.67,18 10.33,18 10.67,17.75C11,17.5 11,17 11,16.5V6H8.5C7.89,6 7.27,6 6.74,6.43C6.21,6.87 5.75,7.74 5.3,8.61L4.34,8.35L5.5,4H18.5Z"></path>
</svg>`,
    content: `
    <style>
      .big-headline{
        margin-top:0;
        margin-bottom:10px;
        font-size:32px;
        font-weight: bold;
      }
    </style>
    <h2 class="big-headline">Put your title here</h2>
    `,
    category: 'Basic',
    attributes: {
        title: 'Big headline'
    }
});

blockManager.add('Mid headline', {
    label: 'Mid headline',
    media: `<svg viewBox="0 0 24 24" style="max-width: 40px">
<path fill="currentColor" d="M18.5,4L19.66,8.35L18.7,8.61C18.25,7.74 17.79,6.87 17.26,6.43C16.73,6 16.11,6 15.5,6H13V16.5C13,17 13,17.5 13.33,17.75C13.67,18 14.33,18 15,18V19H9V18C9.67,18 10.33,18 10.67,17.75C11,17.5 11,17 11,16.5V6H8.5C7.89,6 7.27,6 6.74,6.43C6.21,6.87 5.75,7.74 5.3,8.61L4.34,8.35L5.5,4H18.5Z"></path>
</svg>`,
    content: `
    <style>
      .mid-headline{
        margin-top:0;
        margin-bottom:10px;
        font-size:28px;
        font-weight: bold;
      }
    </style>
    <h3 class="mid-headline">Put your title here</h3>
    `,
    category: 'Basic',
    attributes: {
        title: 'Mid headline'
    }
});

blockManager.add('Small headline', {
    label: 'Small headline',
    media: `<svg viewBox="0 0 24 24" style="max-width: 32px">
<path fill="currentColor" d="M18.5,4L19.66,8.35L18.7,8.61C18.25,7.74 17.79,6.87 17.26,6.43C16.73,6 16.11,6 15.5,6H13V16.5C13,17 13,17.5 13.33,17.75C13.67,18 14.33,18 15,18V19H9V18C9.67,18 10.33,18 10.67,17.75C11,17.5 11,17 11,16.5V6H8.5C7.89,6 7.27,6 6.74,6.43C6.21,6.87 5.75,7.74 5.3,8.61L4.34,8.35L5.5,4H18.5Z"></path>
</svg>`,
    content: `
    <style>
      .small-headline{
        margin-top:0;
        margin-bottom:10px;
        font-size:24px;
        font-weight: bold;
      }
    </style>
    <h4 class="small-headline">Put your title here</h4>
    `,
    category: 'Basic',
    attributes: {
        title: 'Small headline'
    }
});

blockManager.add('Paragraph', {
    label: 'Paragraph',
    media: `<svg viewBox="0 0 24 24" style="max-width: 27px">
<path fill="currentColor" d="M6.3,17.7c1-0.1,1.6-0.3,1.9-0.6c0.2-0.3,0.4-1,0.4-2.1V3.4c0-0.9-0.1-1.5-0.4-1.8C7.8,1.2,7.2,1,6.3,1V0.5h6.9
		c2.2,0,3.9,0.4,5.1,1.3c1.2,0.9,1.8,2,1.8,3.5c0,1.8-0.7,3.1-2,4c-1.3,0.8-3,1.2-4.9,1.2c-0.3,0-0.6,0-1.1,0s-0.8,0-1,0v4.9
		c0,1,0.2,1.6,0.5,1.9c0.3,0.3,1,0.4,2,0.5v0.5H6.3V17.7z M15.2,2c-0.7-0.3-1.7-0.5-2.8-0.5c-0.5,0-0.9,0.1-1,0.2
		c-0.1,0.1-0.2,0.4-0.2,0.7v7c0.5,0,0.8,0.1,0.9,0.1c0.1,0,0.3,0,0.4,0c1.2,0,2.2-0.2,2.9-0.5c1.3-0.6,1.9-1.8,1.9-3.6
		C17.2,3.7,16.6,2.6,15.2,2z"></path>
</svg>`,
    content: `
    <style>
      .paragraph{
        margin-top:0;
        margin-bottom:10px;
        font-size: 16px;
        font-weight: normal;
      }
    </style>
    <p class="Paragraph">Put your title here</p>
    `,
    category: 'Basic',
    attributes: {
        title: 'Paragraph'
    }
});
