segment_filter
==============

ExpressionEngine plugin to enforce strict URLs by disallowing or permitting only certain values for a specified segment.

For example, iF segment_2 != '' then redirect to /segment_1:

    {exp:segment_filter number='2'}

If segment_2 != '' then redirect to /somewhere/else:

    {exp:segment_filter number='2' redirect='/somewhere/else'}

If segment_2 != 'this' or 'that' then redirect to /segment_1:

    {exp:segment_filter number='2' permitted='this|that'}
