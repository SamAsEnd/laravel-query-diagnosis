<?php

namespace SamAsEnd\QueryDiagnosis\Enums;

enum JoinType: string
{
    /**
     * A full table scan is done for the table (all rows are read).
     * This is bad if the table is large and the table is joined against a previous table!
     * This happens when the optimizer could not find any usable index to access rows.
     *
     * @link https://mariadb.com/kb/en/explain/#type-column
     * @link https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#jointype_all
     */
    case ALL = 'ALL';

    /**
     * There is only one possibly matching row in the table.
     * The row is read before the optimization phase and all columns in the table are treated as constants.
     *
     * @link https://mariadb.com/kb/en/explain/#type-column
     * @link https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#jointype_const
     */
    case CONSTANT = 'const';

    /**
     * A unique index is used to find the rows. This is the best possible plan to find the row.
     *
     * @link https://mariadb.com/kb/en/explain/#type-column
     * @link https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#jointype_eq_ref
     */
    case EQ_REF = 'eq_ref';

    /**
     * A fulltext index is used to access the rows.
     *
     * @link https://mariadb.com/kb/en/explain/#type-column
     * @link https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#jointype_fulltext
     */
    case FULLTEXT = 'fulltext';

    /**
     * A 'range' access is done for several index and the found rows are merged.
     * The key column shows which keys are used.
     *
     * @link https://mariadb.com/kb/en/explain/#type-column
     * @link https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#jointype_index_merge
     */
    case INDEX_MERGE = 'index_merge';

    /**
     * This is similar as ref, but used for sub queries that are transformed to key lookups.
     *
     * @link https://mariadb.com/kb/en/explain/#type-column
     * @link https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#jointype_index_subquery
     */
    case INDEX_SUBQUERY = 'index_subquery';

    /**
     * A full scan over the used index.
     * Better than ALL but still bad if index is large and the table is joined against a previous table.
     *
     * @link https://mariadb.com/kb/en/explain/#type-column
     * @link https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#jointype_index
     */
    case INDEX = 'index';

    /**
     * The table will be accessed with a key over one or more value ranges.
     *
     * @link https://mariadb.com/kb/en/explain/#type-column
     * @link https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#jointype_range
     */
    case RANGE = 'range';

    /**
     * Like 'ref' but in addition another search for the 'null' value is done if the first value was not found.
     * This happens usually with sub queries.
     *
     * @link https://mariadb.com/kb/en/explain/#type-column
     * @link https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#jointype_ref_or_null
     */
    case REF_OR_NULL = 'ref_or_null';

    /**
     * A non-unique index or prefix of an unique index is used to find the rows.
     * Good if the prefix doesn't match many rows.
     *
     * @link https://mariadb.com/kb/en/explain/#type-column
     * @link https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#jointype_ref
     */
    case REF = 'ref';

    /**
     * The table has 0 or 1 rows. The table has only one row (= system table).
     * This is a special case of the const join type.
     *
     * @link https://mariadb.com/kb/en/explain/#type-column
     * @link https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#jointype_system
     */
    case SYSTEM = 'system';

    /**
     * This is similar as eq_ref, but used for sub queries that are transformed to key lookups
     *
     * @link https://mariadb.com/kb/en/explain/#type-column
     * @link https://dev.mysql.com/doc/refman/8.0/en/explain-output.html#jointype_unique_subquery
     */
    case UNIQUE_SUBQUERY = 'unique_subquery';
}
