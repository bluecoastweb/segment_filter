segment_filter
==============

ExpressionEngine plugin to enforce strict URLs by disallowing or permitting only certain values for a specified segment.

For example, if segment_2 != '' then redirect to /segment_1:

    {exp:segment_filter number='2'}

Or specify a non-default redirect:

    {exp:segment_filter number='2' redirect='/somewhere/else'}

Or redirect to /segment_1/segment_2 (the default) if segment_3 is not within the specified whitelist of permitted values:

    {exp:segment_filter number='3' permitted='apples|oranges|mangoes'}
