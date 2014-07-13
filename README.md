segment_filter
==============

ExpressionEngine plugin to enforce strict URLs by permitting only certain values for a specified segment.

For example, if `segment_2` != '' then redirect to `/segment_1`:

    {exp:segment_filter number='2'}

Or specify a non-default redirect:

    {exp:segment_filter number='2' redirect='/somewhere/else'}

Or if `segment_3` is not within a whitelist of permitted values, then redirect to `/segment_1/segment_2`:

    {exp:segment_filter number='3' permitted='apples|oranges|mangoes'}
