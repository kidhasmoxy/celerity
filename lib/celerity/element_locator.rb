module Celerity

  #
  # Used internally to locate elements on the page.
  #

  class ElementLocator
    include Celerity::Exception
    attr_accessor :idents


    def initialize(container, element_class)
      container.assert_exists

      @container     = container
      @object        = container.object
      @element_class = element_class
      @attributes    = @element_class::ATTRIBUTES # could check for 'strict' here?
      @idents        = @element_class::TAGS
      @tags          = @idents.map { |e| e.tag.downcase }
    end

    def find_by_conditions(conditions) # TODO: refactor without performance hit
      return nil unless @object # probably means we're on a TextPage (content-type is "text/plain")

      @condition_idents = []
      attributes = Hash.new { |h, k| h[k] = [] }
      index = 0 # by default, return the first matching element
      text = nil

      conditions.each do |how, what|
        case how
        when :object
          unless what.is_a?(HtmlUnit::Html::HtmlElement) || what.nil?
            raise ArgumentError, "expected an HtmlUnit::Html::HtmlElement subclass, got #{what.inspect}:#{what.class}"
          end
          return what
        when :xpath
          return find_by_xpath(what)
        when :label
          return find_by_label(what) unless @attributes.include?(:label)
        when :class_name
          how = :class
        when :url
          how = :href
        when :caption
          how = :text
        end

        if how == :id && conditions.size == 1
          return find_by_id(what)
        elsif @attributes.include?(how = how.to_sym)
          attributes[how] << what
        elsif how == :index
          index = what.to_i - INDEX_OFFSET
        elsif how == :text
          text = what
        else
          raise MissingWayOfFindingObjectException, "No how #{how.inspect}"
        end
      end

      @idents.each do |ident|
        merged = attributes.merge(ident.attributes) { |key, v1, v2| v1 | v2 }
        id = Identifier.new(ident.tag, merged)
        id.text = ident.text || text # «original» identifier takes precedence for :text
        @condition_idents << id
      end

      if index == 0
        element_by_idents(@condition_idents)
      else
        elements_by_idents(@condition_idents)[index]
      end

    rescue HtmlUnit::ElementNotFoundException
      nil # for rcov
    end

    def find_by_id(what)
      case what
      when Regexp
        elements_by_tag_names.find { |elem| elem.getId =~ what }
      when String
        obj = @object.getElementById(what)
        return obj if @tags.include?(obj.getTagName)

        $stderr.puts "warning: multiple elements with identical id? (#{what.inspect})" if $VERBOSE
        elements_by_tag_names.find { |elem| elem.getId == what }
      else
        raise TypeError, "expected String or Regexp, got #{what.inspect}:#{what.class}"
      end
    end

    def find_by_xpath(what)
      what = ".#{what}" if what[0].chr == "/"
      @object.getByXPath(what).to_a.first
    end

    def find_by_label(what)
      obj = elements_by_tag_names(%w[label]).find { |e| matches?(e.asText, what) }

      return nil unless obj && (ref = obj.getReferencedElement)
      return ref if @tags.include?(ref.getTagName)

      find_by_id obj.getForAttribute
    end

    def elements_by_idents(idents = @idents)
      get_by_idents(:select, idents)
    end

    def element_by_idents(idents = @idents)
      get_by_idents(:find, idents)
    end

    private

    def get_by_idents(meth, idents)
      with_nullpointer_retry do
        @object.getAllHtmlChildElements.send(meth) do |e|
          next unless @tags.include?(e.getTagName)
          idents.any? { |id| element_matches_ident?(e, id) }
        end
      end
    end

    def element_matches_ident?(element, ident)
      return false unless ident.tag == element.getTagName

      attr_result = ident.attributes.all? do |key, values|
        values.any? { |val| matches?(element.getAttribute(key.to_s), val) }
      end

      if ident.text
        attr_result && matches?(element.asText.strip, ident.text)
      else
        attr_result
      end
    end

    def elements_by_tag_names(tags = @tags)
      with_nullpointer_retry do
        # HtmlUnit's getHtmlElementsByTagNames won't get elements in the correct
        # order (making :index fail), so we're using getAllHtmlChildElements instead.
        @object.getAllHtmlChildElements.select do |elem|
          tags.include?(elem.getTagName)
        end
      end
    end

    # HtmlUnit throws NPEs sometimes when we're locating elements
    # Retry seems to work fine.
    def with_nullpointer_retry(max_retries = 3)
      tries = 0
      yield
    rescue java.lang.NullPointerException => e
      raise e if tries >= max_retries

      tries += 1
      $stderr.puts "warning: celerity caught #{e} - retry ##{tries}"
      retry
    end

    def matches?(string, what)
      Regexp === what ? string.strip =~ what : string == what.to_s
    end

  end # ElementLocator
end # Celerity
