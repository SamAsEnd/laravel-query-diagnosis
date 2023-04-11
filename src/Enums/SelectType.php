<?php

namespace SamAsEnd\QueryDiagnosis\Enums;

enum SelectType: string
{
    /**
     * The SUBQUERY is DEPENDENT.
     */
    case DEPENDENT_SUBQUERY = 'DEPENDENT SUBQUERY';

    /**
     * The UNION is DEPENDENT.
     */
    case DEPENDENT_UNION = 'DEPENDENT UNION';

    /**
     * The SELECT is DERIVED from the PRIMARY.
     */
    case DERIVED = 'DERIVED';

    /**
     * The SUBQUERY is MATERIALIZED.
     * Materialized tables will be populated at first access and will be accessed by the primary key (= one key lookup).
     * Number of rows in EXPLAIN shows the cost of populating the table
     */
    case MATERIALIZED = 'MATERIALIZED';

    /**
     * The SELECT is in the outermost query, but there is also a SUBQUERY within it.
     */
    case PRIMARY = 'PRIMARY';

    /**
     * It is a simple SELECT query without any SUBQUERY or UNION.
     */
    case SIMPLE = 'SIMPLE';

    /**
     * The SELECT is a SUBQUERY of the PRIMARY.
     */
    case SUBQUERY = 'SUBQUERY';

    /**
     * The SUBQUERY is UNCACHEABLE.
     */
    case UNCACHEABLE_SUBQUERY = 'UNCACHEABLE SUBQUERY';

    /**
     * The UNION is UNCACHEABLE.
     */
    case UNCACHEABLE_UNION = 'UNCACHEABLE UNION';

    /**
     * The SELECT is a UNION of the PRIMARY.
     */
    case UNION = 'UNION';

    /**
     * The result of the UNION.
     */
    case UNION_RESULT = 'UNION RESULT';

    /**
     * The SELECT uses a Lateral Derived optimization
     */
    case LATERAL_DERIVED = 'LATERAL DERIVED';
}
