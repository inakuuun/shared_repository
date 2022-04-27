# 
# /*
#  * *********** WARNING **************
#  * This file generated by ModPerl::WrapXS/0.01
#  * Any changes made here will be lost
#  * ***********************************
#  * 01: lib/ModPerl/Code.pm:716
#  * 02: lib/ModPerl/WrapXS.pm:635
#  * 03: lib/ModPerl/WrapXS.pm:1186
#  * 04: Makefile.PL:435
#  * 05: Makefile.PL:333
#  * 06: Makefile.PL:59
#  */
# 


package Apache2::RequestIO;

use strict;
use warnings FATAL => 'all';



use Apache2::XSLoader ();
our $VERSION = '2.000011';
Apache2::XSLoader::load __PACKAGE__;



1;
__END__

=head1 NAME

Apache2::RequestIO - Perl API for Apache request record IO




=head1 Synopsis

  use Apache2::RequestIO ();
  
  $rc = $r->discard_request_body();
  
  $r->print("foo", "bar");
  $r->puts("foo", "bar"); # same as print, but no flushing
  $r->printf("%s $d", "foo", 5);
  
  $r->read($buffer, $len);
  
  $r->rflush();
  
  $r->sendfile($filename);
  
  $r->write("foobartarcar", 3, 5);




=head1 Description

C<Apache2::RequestIO> provides the API to perform IO on the L<Apache
request object|docs::2.0::api::Apache2::RequestRec>.




=head1 API

C<Apache2::RequestIO> provides the following functions and/or methods:




=head2 C<discard_request_body>

In HTTP/1.1, any method can have a body.  However, most GET handlers
wouldn't know what to do with a request body if they received one.
This helper routine tests for and reads any message body in the
request, simply discarding whatever it receives.  We need to do this
because failing to read the request body would cause it to be
interpreted as the next request on a persistent connection.

  $rc = $r->discard_request_body();

=over 4

=item obj: C<$r>
( C<L<Apache2::RequestRec object|docs::2.0::api::Apache2::RequestRec>> )

The current request

=item ret: C<$rc> ( integer )

C<L<APR::Const status constant|docs::2.0::api::APR::Const>> if request
is malformed, C<Apache2::Const::OK> otherwise.

=item since: 2.0.00

=back

Since we return an error status if the request is malformed, this
routine should be called at the beginning of a no-body handler, e.g.,

   use Apache2::Const -compile => qw(OK);
   $rc = $r->discard_request_body;
   return $rc if $rc != Apache2::Const::OK;





=head2 C<print>

Send data to the client.

  $cnt = $r->print(@msg);

=over 4

=item obj: C<$r>
( C<L<Apache2::RequestRec object|docs::2.0::api::Apache2::RequestRec>> )

=item arg1: C<@msg> ( ARRAY )

Data to send

=item ret: C<$cnt> ( number )

How many bytes were sent (or buffered).  If zero bytes were
sent, C<print> will return C<0E0>, or "zero but true," which
will still evaluate to C<0> in a numerical context.

=item excpt: C<L<APR::Error|docs::2.0::api::APR::Error>>

=item since: 2.0.00

=back

The data is flushed only if STDOUT stream's C<$|> is true. Otherwise
it's buffered up to the size of the buffer, flushing only excessive
data.




=head2 C<printf>

Format and send data to the client (same as C<printf>).

  $cnt = $r->printf($format, @args);

=over 4

=item obj: C<$r>
( C<L<Apache2::RequestRec object|docs::2.0::api::Apache2::RequestRec>> )

=item arg1: C<$format> ( string )

Format string, as in the Perl core C<printf> function.

=item arg2: C<@args> ( ARRAY )

Arguments to be formatted, as in the Perl core C<printf> function.

=item ret: C<$cnt> ( number )

How many bytes were sent (or buffered)

=item excpt: C<L<APR::Error|docs::2.0::api::APR::Error>>

=item since: 2.0.00

=back

The data is flushed only if STDOUT stream's C<$|> is true. Otherwise
it's buffered up to the size of the buffer, flushing only excessive
data.




=head2 C<puts>

Send data to the client

  $cnt = $r->puts(@msg);

=over 4

=item obj: C<$r>
( C<L<Apache2::RequestRec object|docs::2.0::api::Apache2::RequestRec>> )

=item arg1: C<@msg> ( ARRAY )

Data to send

=item ret: C<$cnt> ( number )

How many bytes were sent (or buffered)

=item excpt: C<L<APR::Error|docs::2.0::api::APR::Error>>

=item since: 2.0.00

=back

C<puts()> is similar to C<L<print()|/C_print_>>, but it won't attempt
to flush data, no matter what the value of STDOUT stream's C<$|>
is. Therefore assuming that STDOUT stream's C<$|> is true, this method
should be a tiny bit faster than C<L<print()|/C_print_>>, especially
if small strings are printed.





=head2 C<read>

Read data from the client.

  $cnt = $r->read($buffer, $len);
  $cnt = $r->read($buffer, $len, $offset);

=over 4

=item obj: C<$r>
( C<L<Apache2::RequestRec object|docs::2.0::api::Apache2::RequestRec>> )

=item arg1: C<$buffer> ( SCALAR )

The buffer to populate with the read data

=item arg2: C<$len> ( number )

How many bytes to attempt to read

=item opt arg3: C<$offset> ( number )

If a non-zero C<$offset> is specified, the read data will be placed at
that offset in the C<$buffer>.

META: negative offset and \0 padding are not supported at the moment

=item ret: C<$cnt> ( number )

How many characters were actually read

=item excpt: C<L<APR::Error|docs::2.0::api::APR::Error>>

=item since: 2.0.00

=back

This method shares a lot of similarities with the Perl core C<read()>
function. The main difference in the error handling, which is done via
C<L<APR::Error exceptions|docs::2.0::api::APR::Error>>




=head2 C<rflush>

Flush any buffered data to the client.

  $r->rflush();

=over 4

=item obj: C<$r>
( C<L<Apache2::RequestRec object|docs::2.0::api::Apache2::RequestRec>> )

=item ret: no return value

=item since: 2.0.00

=back

Unless STDOUT stream's C<$|> is false, data sent via
C<L<$r-E<gt>print()|/C_print_>> is buffered. This method flushes that
data to the client.





=head2 C<sendfile>

Send a file or a part of it

  $rc = $r->sendfile($filename);
  $rc = $r->sendfile($filename, $offset);
  $rc = $r->sendfile($filename, $offset, $len);

=over 4

=item obj: C<$r>
( C<L<Apache2::RequestRec object|docs::2.0::api::Apache2::RequestRec>> )

=item arg1: C<$filename> ( string )

The full path to the file (using C</> on all systems)

=item opt arg2: C<$offset> ( integer )

Offset into the file to start sending.

No offset is used if C<$offset> is not specified.

=item opt arg3: C<$len> ( integer )

How many bytes to send.

If not specified the whole file is sent (or a part of it, if
C<$offset> if specified)

=item ret: C<$rc> ( C<L<APR::Const status
constant|docs::2.0::api::APR::Const>> )

On success,
C<L<APR::Const::SUCCESS|docs::2.0::api::APR::Const/C_APR__Const__SUCCESS_>> is
returned.

In case of a failure -- a failure code is returned, in which case
normally it should be returned to the caller.

=item excpt: C<L<APR::Error|docs::2.0::api::APR::Error>>

Exceptions are thrown only when this function is called in the VOID
context. So if you don't want to handle the errors, just don't ask for
a return value and the function will handle all the errors on its own.

=item since: 2.0.00

=back





=head2 C<write>

Send partial string to the client

  $cnt = $r->write($buffer);
  $cnt = $r->write($buffer, $len);
  $cnt = $r->write($buffer, $len, $offset);

=over 4

=item obj: C<$r>
( C<L<Apache2::RequestRec object|docs::2.0::api::Apache2::RequestRec>> )

=item arg1: C<$buffer> ( SCALAR )

The string with data

=item opt arg2: C<$len> ( SCALAR )

How many bytes to send. If not specified, or -1 is specified, all the
data in C<$buffer> (or starting from C<$offset>) will be sent.

=item opt arg3: C<$offset> ( number )

Offset into the C<$buffer> string.

=item ret: C<$cnt> ( number )

How many bytes were sent (or buffered)

=item excpt: C<L<APR::Error|docs::2.0::api::APR::Error>>

=item since: 2.0.00

=back

Examples:

Assuming that we have a string:

  $string = "123456789";

Then:

  $r->write($string);

sends:

  123456789

Whereas:

  $r->write($string, 3);

sends:

  123

And:

  $r->write($string, 3, 5);

sends:

  678

Finally:

  $r->write($string, -1, 5);

sends:

  6789








=head1 TIE Interface

The TIE interface implementation. This interface is used for HTTP
request handlers, when running under C<L<SetHandler
perl-script|docs::2.0::user::config::config/C_perl_script_>> and
Perl doesn't have perlio enabled.

See the I<perltie> manpage for more information.




=head2 C<BINMODE>

=over 4

=item since: 2.0.00

=back

NoOP

See the I<binmode> Perl entry in the I<perlfunc> manpage



=head2 C<CLOSE>

=over 4

=item since: 2.0.00

=back

NoOP

See the I<close> Perl entry in the I<perlfunc> manpage



=head2 C<FILENO>

=over 4

=item since: 2.0.00

=back

See the I<fileno> Perl entry in the I<perlfunc> manpage




=head2 C<GETC>

=over 4

=item since: 2.0.00

=back

See the I<getc> Perl entry in the I<perlfunc> manpage




=head2 C<OPEN>

=over 4

=item since: 2.0.00

=back

See the I<open> Perl entry in the I<perlfunc> manpage





=head2 C<PRINT>

=over 4

=item since: 2.0.00

=back

See the I<print> Perl entry in the I<perlfunc> manpage




=head2 C<PRINTF>

=over 4

=item since: 2.0.00

=back

See the I<printf> Perl entry in the I<perlfunc> manpage




=head2 C<READ>

=over 4

=item since: 2.0.00

=back

See the I<read> Perl entry in the I<perlfunc> manpage





=head2 C<TIEHANDLE>

=over 4

=item since: 2.0.00

=back

See the I<tie> Perl entry in the I<perlfunc> manpage




=head2 C<UNTIE>

=over 4

=item since: 2.0.00

=back

NoOP

See the I<untie> Perl entry in the I<perlfunc> manpage





=head2 C<WRITE>

=over 4

=item since: 2.0.00

=back

See the I<write> Perl entry in the I<perlfunc> manpage




=head1 Deprecated API

The following methods are deprecated, Apache plans to remove those in
the future, therefore avoid using them.



=head2 C<get_client_block>

This method is deprecated since the C implementation is buggy and we
don't want you to use it at all. Instead use the plain
C<L<$r-E<gt>read()|/C_read_>>.




=head2 C<setup_client_block>

This method is deprecated since
C<L<$r-E<gt>get_client_block|/C__get_client_block_>> is deprecated.




=head2 C<should_client_block>

This method is deprecated since
C<L<$r-E<gt>get_client_block|/C__get_client_block_>> is deprecated.






=head1 See Also

L<mod_perl 2.0 documentation|docs::2.0::index>.




=head1 Copyright

mod_perl 2.0 and its core modules are copyrighted under
The Apache Software License, Version 2.0.




=head1 Authors

L<The mod_perl development team and numerous
contributors|about::contributors::people>.

=cut

