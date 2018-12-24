{^include file=$mblheader_file^}
{^if $progress_step neq 4^}

{^if $progress_step eq 1^}
<!-- STEP1 -->
{^elseif $progress_step eq 2^}
<!-- STEP2 -->
{^else^}
<!-- STEP3 -->
{^/if^}

{^else^}
<!-- STEP4 -->
{^/if^}
{^include file=$mblfooter_file^}